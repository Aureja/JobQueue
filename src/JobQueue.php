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
use Aureja\JobQueue\Register\JobFactoryRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var JobFactoryRegistry
     */
    private $factoryRegistry;

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
     * @param EventDispatcherInterface $eventDispatcher
     * @param JobFactoryRegistry $factoryRegistry
     * @param JobReportManagerInterface $reportManager
     * @param JobRestoreManager $restoreManager
     * @param array $queues
     * @param int $resetTimeout
     */
    public function __construct(
        JobConfigurationManagerInterface $configurationManager,
        EventDispatcherInterface $eventDispatcher,
        JobFactoryRegistry $factoryRegistry,
        JobReportManagerInterface $reportManager,
        JobRestoreManager $restoreManager,
        array $queues,
        $resetTimeout
    ) {
        $this->configurationManager = $configurationManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->factoryRegistry = $factoryRegistry;
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
            $job = $this->getJob($configuration);
            $configuration->increaseOrderNr();

            $this->saveJobState($configuration, JobState::STATE_RUNNING);

            $report = $this->reportManager->create($configuration);
            $state = $job->run($report);

            if (JobState::STATE_FINISHED === $state) {
                $configuration->setNextStart(new \DateTime('+' . $configuration->getPeriod() . ' seconds'));
                $report->setSuccessful(true);
            }

            $report->setEndedAt();

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
     * @return bool
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

                return true;
            }
        }

        return false;
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
        if($this->reset($queue)) {
            return null;
        }

        if ($this->canRunQueueJob($queue)) {
            return $this->configurationManager->findNextByQueue($queue);
        }

        return null;
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
     * @param JobConfigurationInterface $configuration
     *
     * @return JobInterface
     */
    private function getJob(JobConfigurationInterface $configuration)
    {
        return $this->factoryRegistry->get($configuration->getFactoryName())->create($configuration);
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
        
        $this->eventDispatcher->dispatch(JobQueueEvents::CHANGE_JOB_STATE, new JobEvent($configuration));
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
