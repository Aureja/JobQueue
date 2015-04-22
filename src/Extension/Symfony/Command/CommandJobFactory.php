<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Symfony\Command;

use Aureja\JobQueue\Extension\Shell\ShellJob;
use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Model\JobConfigurationInterface;

/**
 * @since 4/17/15 12:24 AM
 */
class CommandJobFactory implements JobFactoryInterface
{

    /**
     * @var CommandBuilder
     */
    private $commandBuilder;

    /**
     * Constructor.
     *
     * @param CommandBuilder $commandBuilder
     */
    public function __construct(CommandBuilder $commandBuilder)
    {
        $this->commandBuilder = $commandBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function create(JobConfigurationInterface $configuration)
    {
        return new ShellJob($this->commandBuilder->build($configuration->getParameter('symfony_command')));
    }
}
