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
 * @since 4/21/15 10:46 PM
 */
class Report implements ReportInterface
{

    /**
     * @var \DateTime
     */
    protected $endedAt;

    /**
     * @var string
     */
    protected $errorOutput;

    /**
     * @var string
     */
    protected $output;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * @var bool
     */
    protected $successful;

    /**
     * {@inheritdoc}
     */
    public function setEndedAt(\DateTime $endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorOutput($errorOutput)
    {
        $this->errorOutput = $errorOutput;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorOutput()
    {
        return $this->errorOutput;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartedAt(\DateTime $startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setSuccessful($successful)
    {
        $this->successful = $successful;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->successful;
    }
}
