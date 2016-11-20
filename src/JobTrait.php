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

use Aureja\JobQueue\Model\JobReportInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/30/15 9:38 PM
 */
trait JobTrait
{
    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * @param JobReportManagerInterface $reportManager
     * 
     * @return $this
     */
    public function setReportManager($reportManager)
    {
        $this->reportManager = $reportManager;

        return $this;
    }

    /**
     * Save job pid.
     *
     * @param int $pid
     * @param JobReportInterface $report
     */
    public function savePid($pid, JobReportInterface $report)
    {
        $report->setPid($pid);
        $this->reportManager->add($report, true);
    }
}
