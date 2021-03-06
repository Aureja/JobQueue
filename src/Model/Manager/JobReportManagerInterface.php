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

use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\JobReportInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:35 PM
 */
interface JobReportManagerInterface
{

    /**
     * Get job configuration reports count.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return int
     */
    public function getCountByConfiguration(JobConfigurationInterface $configuration);

    /**
     * Get job configuration reports.
     *
     * @param JobConfigurationInterface $configuration
     * @param int $offset
     * @param int $limit
     *
     * @return array|JobReportInterface[]
     */
    public function getJobReportsByConfiguration(JobConfigurationInterface $configuration, $offset, $limit);

    /**
     * Get ;ast started job configuration report.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobReportInterface|null
     */
    public function getLastStartedByConfiguration(JobConfigurationInterface $configuration);

    /**
     * Create new job report object.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobReportInterface
     */
    public function create(JobConfigurationInterface $configuration);

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
