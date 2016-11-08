<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Tests\Unit\Extension\Php;

use Aureja\JobQueue\Extension\Php\PhpJob;
use Aureja\JobQueue\JobState;
use Aureja\JobQueue\Model\JobReport;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 11:23 PM
 */
class PhpJobTest extends TestCase
{
    public function testRunScript_Failed()
    {
        $job = new PhpJob('<?php echo "Hello word!"', $this->getMockReportManager());
        $report = new JobReport();

        $state = $job->run($report);

        $this->assertEquals(JobState::STATE_FAILED, $state);
        $this->assertEquals(
            "PHP Parse error:  syntax error, unexpected end of file, expecting ',' or ';' in - on line 1",
            $report->getErrorOutput()
        );
    }


    public function testRunScript_Finished()
    {
        $job = new PhpJob('<?php echo "Hello word!";', $this->getMockReportManager());
        $report = new JobReport();

        $state = $job->run($report);

        $this->assertEquals(JobState::STATE_FINISHED, $state);
        $this->assertEquals('Hello word!', $report->getOutput());
    }

    /**
     * @return MockObject|JobReportManagerInterface
     */
    private function getMockReportManager()
    {
        return $this->getMock('Aureja\\JobQueue\\Model\\Manager\\JobReportManagerInterface');
    }
}
