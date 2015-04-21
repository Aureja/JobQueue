<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Tests\Unit\Extension\Service;

use Aureja\JobQueue\Extension\Symfony\Service\ServiceJob;
use Aureja\JobQueue\Model\Report;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 * @since 4/16/15 10:53 PM
 */
class ServiceJobTest extends TestCase
{

    public function testRunServiceMethod_NotFoundServiceJobExceptionRaised()
    {
        $this->setExpectedException(
            'Aureja\\JobQueue\\Extension\\Symfony\\Exception\\NotFoundServiceJobException',
            'Not found aureja.symfony_job service createJob method'
        );

        $job = new ServiceJob($this->getMockContainer(), 'aureja.symfony_job', 'createJob');
        $report = new Report();

        $job->run($report);
    }

    /**
     * @return MockObject|ContainerInterface
     */
    private function getMockContainer()
    {
        $mock = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerInterface');

        return $mock;
    }
}
