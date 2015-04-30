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

use Aureja\JobQueue\Model\JobReportInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/30/15 9:38 PM
 */
trait JobTrait
{

    /**
     * Save job pid.
     *
     * @param int $pid
     * @param JobReportInterface $report
     */
    public function savePid($pid, JobReportInterface $report)
    {
        $this->reportManager->add($report->setPid($pid), true);
    }
}
