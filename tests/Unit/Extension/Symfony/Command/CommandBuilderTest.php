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

use Aureja\JobQueue\Extension\PhpUtils;
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
        $builder = new CommandBuilder('aureja_bin', 'dev');

        $this->assertEquals(
            sprintf('%s aureja_bin/console aureja:command --env=dev --no-debug', PhpUtils::getPhp()),
            $builder->build('aureja:command')
        );
    }

    public function testBuild_Prod()
    {
        $builder = new CommandBuilder('aureja_bin', 'prod');

        $this->assertEquals(
            sprintf('%s aureja_bin/console aureja:command --env=prod --no-debug', PhpUtils::getPhp()),
            $builder->build('aureja:command')
        );
    }
}
