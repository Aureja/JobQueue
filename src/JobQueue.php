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
     * Constructor.
     *
     * @param JobConfigurationManagerInterface $configurationManager
     * @param JobProviderInterface $jobProvider
     * @param JobReportManagerInterface $reportManager
     * @param JobRestoreManager $restoreManager
     */
    public function __construct(
        JobConfigurationManagerInterface $configurationManager,
        JobProviderInterface $jobProvider,
        JobReportManagerInterface $reportManager,
        JobRestoreManager $restoreManager
    ) {
        $this->configurationManager = $configurationManager;
        $this->jobProvider = $jobProvider;
        $this->reportManager = $reportManager;
        $this->restoreManager = $restoreManager;
    }

    /**
     * Run job queue.
     *
     * @param string $queue
     */
    public function run($queue)
    {
        $configuration = $this->configurationManager->findNext($queue);
        if (null === $configuration) {
            return;
        }

        $running = $this->configurationManager
            ->findByQueueAndState($configuration->getQueue(), JobState::STATE_RUNNING);

        if (null !== $running) {
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

            $configuration->addReport($report);
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
            throw new JobConfigurationException('Function posix_getsid don\'t exists');
        }

        foreach ($this->configurationManager->findPotentialDeadJobs($queue) as $configuration) {
            if ($this->restoreManager->reset($configuration)) {
                $this->configurationManager->save();

                break;
            }
        }
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
}
