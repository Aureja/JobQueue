<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Tests\Unit\Extension\Symfony\Command;

use Aureja\JobQueue\Extension\Symfony\Command\CommandBuilder;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/17/15 12:39 AM
 */
class CommandBuilderTest extends TestCase
{

    public function testBuild_Dev()
    {
        $builder = new CommandBuilder('aureja/fake-dir', 'dev');

        $this->assertEquals(
            '/usr/bin/php5 aureja/fake-dir/console aureja:command --env=dev',
            $builder->build('aureja:command')
        );
    }

    public function testBuild_Prod()
    {
        $builder = new CommandBuilder('aureja/fake-dir/', 'prod');

        $this->assertEquals(
            '/usr/bin/php5 aureja/fake-dir/console aureja:command --env=prod',
            $builder->build('aureja:command')
        );
    }
}
