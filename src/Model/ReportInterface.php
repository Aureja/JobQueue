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
interface ReportInterface
{

    /**
     * Set ended at.
     *
     * @param \DateTime $endedAt
     *
     * @return ReportInterface
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
     * @return ReportInterface
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
     * @return ReportInterface
     */
    public function setOutput($output);

    /**
     * Get output.
     *
     * @return string
     */
    public function getOutput();

    /**
     * Set started at.
     *
     * @param \DateTime $startedAt
     *
     * @return ReportInterface
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
     * @return ReportInterface
     */
    public function setSuccessful($successful);

    /**
     * Is successful.
     *
     * @return bool
     */
    public function isSuccessful();
}
