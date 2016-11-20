<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Tests\Unit\Extension\Shell;

use Aureja\JobQueue\Extension\Shell\ShellJob;
use Aureja\JobQueue\JobState;
use Aureja\JobQueue\Model\JobReport;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 11:21 PM
 */
class ShellJobTest extends TestCase
{

    public function testRunCommand_Failed()
    {
        $job = new ShellJob('aureja_fake 1');
        $job->setReportManager($this->getMockReportManager());
        $report = new JobReport();

        $state = $job->run($report);

        $this->assertEquals(JobState::STATE_FAILED, $state);
        $this->assertEquals('sh: 1: aureja_fake: not found', $report->getErrorOutput());
    }


    public function testRunCommand_Finished()
    {
        $job = new ShellJob('sleep 1');
        $job->setReportManager($this->getMockReportManager());
        $report = new JobReport();

        $state = $job->run($report);

        $this->assertEquals(JobState::STATE_FINISHED, $state);
        $this->assertEmpty($report->getOutput());
    }

    /**
     * @return MockObject|JobReportManagerInterface
     */
    private function getMockReportManager()
    {
        return $this->getMock('Aureja\\JobQueue\\Model\\Manager\\JobReportManagerInterface');
    }
}
