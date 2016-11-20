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
use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\JobReportInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/9/15 4:15 PM
 */
class JobRestoreManager
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, JobReportManagerInterface $reportManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->reportManager = $reportManager;
    }

    /**
     * Reset job.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return bool
     */
    public function reset(JobConfigurationInterface $configuration)
    {
        if (!function_exists('posix_getsid')) {
            throw JobConfigurationException::create('Function posix_getsid don\'t exists');
        }

        if ($this->isDead($configuration)) {
            $configuration
                ->setState(JobState::STATE_RESTORED)
                ->setNextStart(new \DateTime());
            $this->saveReport($configuration);
            
            $this->eventDispatcher->dispatch(JobQueueEvents::CHANGE_JOB_STATE, new JobEvent($configuration));

            return true;
        }

        return false;
    }

    /**
     * Create restored job report.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobReportInterface
     */
    private function saveReport(JobConfigurationInterface $configuration)
    {
        $report = $this->reportManager->create($configuration);
        $report
            ->setEndedAt()
            ->setOutput('Job was dead and restored.')
            ->setSuccessful(true);

        $this->reportManager->add($report, true);
    }

    /**
     * Checks or job is dead.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return bool
     */
    private function isDead(JobConfigurationInterface $configuration)
    {
        $report = $this->reportManager->getLastStartedByConfiguration($configuration);

        return $report && $report->getPid() && (false === $report->isSuccessful()) && !posix_getsid($report->getPid());
    }
}
