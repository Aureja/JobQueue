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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 1:14 AM
 */
interface JobInterface
{

    /**
     * Get job pid.
     *
     * @return null|int
     */
    public function getPid();

    /**
     * Run job.
     *
     * @param JobReportInterface $report
     *
     * @return string Return job status.
     */
    public function run(JobReportInterface $report);
}
