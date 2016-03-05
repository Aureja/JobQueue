<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue;

use Aureja\JobQueue\Exception\JobConfigurationException;
use Aureja\JobQueue\Exception\JobFactoryException;
use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\Manager\JobConfigurationManagerInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
use Aureja\JobQueue\Provider\JobProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/29/15 10:18 PM
 */
class JobQueue
{

    /**
     * @var JobConfigurationManagerInterface
     */
    private $configurationManager;

    /**
     * @var JobProviderInterface
     */
    private $jobProvider;

    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * @var JobRestoreManager
     */
    private $restoreManager;

    /**
     * @var array
     */
    private $queues;

    /**
     * @var int
     */
    private $resetTimeout;

    /**
     * Constructor.
     *
     * @param JobConfigurationManagerInterface $configurationManager
     * @param JobProviderInterface $jobProvider
     * @param JobReportManagerInterface $reportManager
     * @param JobRestoreManager $restoreManager
     * @param array $queues
     * @param int $resetTimeout
     */
    public function __construct(
        JobConfigurationManagerInterface $configurationManager,
        JobProviderInterface $jobProvider,
        JobReportManagerInterface $reportManager,
        JobRestoreManager $restoreManager,
        array $queues,
        $resetTimeout
    ) {
        $this->configurationManager = $configurationManager;
        $this->jobProvider = $jobProvider;
        $this->reportManager = $reportManager;
        $this->restoreManager = $restoreManager;
        $this->queues = $queues;
        $this->resetTimeout = $resetTimeout;
    }

    /**
     * Run job queue.
     *
     * @param string $queue
     */
    public function run($queue)
    {
        $configuration = $this->getConfiguration($queue);
        if (null === $configuration) {
            return;
        }

        try {
            $job = $this->jobProvider->getFactory($configuration)->create($configuration);
            $configuration->setOrderNr($configuration->getOrderNr() + 1);

            $this->saveJobState($configuration, JobState::STATE_RUNNING);

            $report = $this->reportManager->create($configuration);
            $state = $job->run($report);

            if ($state === JobState::STATE_FINISHED) {
                $configuration->setNextStart(new \DateTime('+' . $configuration->getPeriod() . ' seconds'));
                $report->setSuccessful(true);
            }

            $report->setEndedAt(new \DateTime());

            $this->saveJobState($configuration, $state);
        } catch (JobFactoryException $e) {
            $this->saveJobState($configuration, JobState::STATE_FAILED);
        }
    }

    /**
     * Reset job.
     *
     * @param string $queue
     *
     * @throws JobConfigurationException
     */
    public function reset($queue)
    {
        if (!function_exists('posix_getsid')) {
            throw JobConfigurationException::create('Function posix_getsid don\'t exists');
        }

        $configurations = $this->configurationManager->findPotentialDeadJobs($this->getNextStartWithTimeout(), $queue);

        foreach ($configurations as $configuration) {
            if ($this->restoreManager->reset($configuration)) {
                $this->configurationManager->save();

                break;
            }
        }
    }

    /**
     * @param null|string $queue
     *
     * @return null|JobConfigurationInterface
     */
    private function getConfiguration($queue = null)
    {
        if (null === $queue) {
            foreach ($this->queues as $queue) {
                $configuration = $this->getConfigurationByQueue($queue);
                if (null !== $configuration) {
                    return $configuration;
                }
            }

            return null;
        }

        return $this->getConfigurationByQueue($queue);
    }

    /**
     * @param string $queue
     *
     * @return JobConfigurationInterface|null
     */
    private function getConfigurationByQueue($queue)
    {
        $configuration = $this->configurationManager->findNextByQueue($queue);
        if (null === $configuration) {
            return null;
        }

        if (false === $this->canRunQueueJob($queue)) {
            $this->reset($queue);

            return null;
        }

        return $configuration;
    }

    /**
     * @param string $queue
     *
     * @return bool
     */
    private function canRunQueueJob($queue)
    {
        $running = $this->configurationManager->findByQueueAndState($queue, JobState::STATE_RUNNING);

        return null === $running;
    }

    /**
     * Save job state.
     *
     * @param JobConfigurationInterface $configuration
     * @param string $state
     */
    private function saveJobState(JobConfigurationInterface $configuration, $state)
    {
        $configuration->setState($state);
        $this->configurationManager->add($configuration, true);
    }

    /**
     * @return \DateTime
     */
    private function getNextStartWithTimeout()
    {
        $now = new \DateTime();
        $now->modify(sprintf('- %d seconds', $this->resetTimeout));

        return $now;
    }
}
