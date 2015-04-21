<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Tests\Unit\Registry;

use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Register\JobFactoryRegistry;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/21/15 11:58 PM
 */
class JobFactoryRegistryTest extends TestCase
{

    /**
     * @var JobFactoryRegistry
     */
    private $registry;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->registry = new JobFactoryRegistry();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->registry);
    }

    public function testAdd()
    {
        $factory = $this->getMockJobFactory();

        $this->registry->add($factory, 'aureja_job');

        $this->assertEquals($factory, $this->registry->getFactory('aureja_job'));
    }

    public function testAdd_JobFactoryExceptionRaised()
    {
        $this->setExpectedException(
            'Aureja\\JobQueue\\Exception\\JobFactoryException',
            'Not found aureja_job job factory'
        );

        $this->registry->getFactory('aureja_job');
    }

    /**
     * @return MockObject|JobFactoryInterface
     */
    private function getMockJobFactory()
    {
        $mock = $this->getMock('Aureja\\JobQueue\\JobFactoryInterface');

        return $mock;
    }
}
