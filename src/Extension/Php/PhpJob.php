<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Php;

use Aureja\JobQueue\JobInterface;
use Aureja\JobQueue\JobState;
use Aureja\JobQueue\Model\JobReportInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\PhpProcess;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 10:37 PM
 */
class PhpJob implements JobInterface
{

    /**
     * @var PhpProcess
     */
    private $process;

    /**
     * Constructor.
     *
     * @param string $script
     */
    public function __construct($script)
    {
        $this->process = new PhpProcess($script);
        $this->process->setTimeout(null);
    }

    /**
     * {@inheritdoc}
     */
    public function getPid()
    {
        return $this->process->getPid();
    }

    /**
     * {@inheritdoc}
     */
    public function run(JobReportInterface $report)
    {
        try {
            $this->process->run();
            if (null === $this->process->getErrorOutput()) {
                $report->setOutput(trim($this->process->getOutput()));

                return JobState::STATE_FINISHED;
            }
            $report->setErrorOutput(trim($this->process->getErrorOutput()));
        } catch (LogicException $e) {
            $report->setErrorOutput($e->getMessage());
        } catch (RuntimeException $e) {
            $report->setErrorOutput($e->getMessage());
        }


        return JobState::STATE_FAILED;
    }
}
