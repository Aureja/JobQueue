<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue;

use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\JobReportInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/9/15 4:15 PM
 */
class JobRestoreManager
{

    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * Constructor.
     *
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct(JobReportManagerInterface $reportManager)
    {
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
        if ($this->isDead($configuration)) {
            $configuration->setState(JobState::STATE_RESTORED);
            $configuration->addReport($this->createReport($configuration));

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
    private  function createReport(JobConfigurationInterface $configuration)
    {
        $report = $this->reportManager->create($configuration);
        $report->setEndedAt(new \DateTime());
        $report->setOutput('Job was dead and restored.');
        $report->setSuccessful(true);

        $this->reportManager->add($report);

        return $report;
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

        if ($report && $report->getPid() && !posix_getsid($report->getPid())) {
            return true;
        }

        return false;
    }
}
