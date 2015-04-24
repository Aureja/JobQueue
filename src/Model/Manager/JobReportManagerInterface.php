<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Model\Manager;

use Aureja\JobQueue\Model\JobReportInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:35 PM
 */
interface JobReportManagerInterface
{

    /**
     * Create new job report object.
     *
     * @return JobReportInterface
     */
    public function create();

    /**
     * Add job report object to persistent layer.
     *
     * @param JobReportInterface $report
     * @param bool $save
     */
    public function add(JobReportInterface $report, $save = false);

    /**
     * Remove job report object from persistent layer.
     *
     * @param JobReportInterface $report
     * @param bool $save
     */
    public function remove(JobReportInterface $report, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear job report objects from persistent layer.
     */
    public function clear();

    /**
     * Get job report object class name.
     *
     * @return string
     */
    public function getClass();
}
