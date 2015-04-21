<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Shell;

use Aureja\JobQueue\JobInterface;
use Aureja\JobQueue\JobState;
use Aureja\JobQueue\Model\ReportInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Process;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 10:37 PM
 */
class ShellJob implements JobInterface
{

    /**
     * @var Process
     */
    private $process;

    /**
     * Constructor.
     *
     * @param string $command
     */
    public function __construct($command)
    {
        $this->process = new Process($command);
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
    public function run(ReportInterface $report)
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
