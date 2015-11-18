<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 11:38 PM
 */
interface JobReportInterface
{

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set job configuration.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobReportInterface
     */
    public function setConfiguration(JobConfigurationInterface $configuration);

    /**
     * Get job configuration.
     *
     * @return JobConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Set ended at.
     *
     * @param \DateTime $endedAt
     *
     * @return JobReportInterface
     */
    public function setEndedAt(\DateTime $endedAt);

    /**
     * Get ended at.
     *
     * @return \DateTime
     */
    public function getEndedAt();

    /**
     * Set error output.
     *
     * @param string $errorOutput
     *
     * @return JobReportInterface
     */
    public function setErrorOutput($errorOutput);

    /**
     * Get error output.
     *
     * @return string
     */
    public function getErrorOutput();

    /**
     * Set output.
     *
     * @param string $output
     *
     * @return JobReportInterface
     */
    public function setOutput($output);

    /**
     * Get output.
     *
     * @return string
     */
    public function getOutput();

    /**
     * Set job pid.
     *
     * @param int $pid
     *
     * @return JobReportInterface
     */
    public function setPid($pid);

    /**
     * Get job pid.
     *
     * @return int
     */
    public function getPid();

    /**
     * Set started at.
     *
     * @param \DateTime $startedAt
     *
     * @return JobReportInterface
     */
    public function setStartedAt(\DateTime $startedAt);

    /**
     * Get started at.
     *
     * @return \DateTime
     */
    public function getStartedAt();

    /**
     * Set successful.
     *
     * @param string $successful
     *
     * @return JobReportInterface
     */
    public function setSuccessful($successful);

    /**
     * Is successful.
     *
     * @return bool
     */
    public function isSuccessful();
}
