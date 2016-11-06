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
use Aureja\JobQueue\JobTrait;
use Aureja\JobQueue\Model\JobReportInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
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
    use JobTrait;

    /**
     * @var PhpProcess
     */
    private $process;

    /**
     * Constructor.
     *
     * @param string $script
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct($script, JobReportManagerInterface $reportManager)
    {
        $this->process = new PhpProcess($script);
        $this->process->setTimeout(null);
        $this->reportManager = $reportManager;
    }

    /**
     * {@inheritdoc}
     */
    public function run(JobReportInterface $report)
    {
        try {
            $this->process->start();
            $this->savePid($this->process->getPid(), $report);
            while ($this->process->isRunning()) {
                // waiting for process to finish
            }

            if ($this->process->isSuccessful()) {
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
