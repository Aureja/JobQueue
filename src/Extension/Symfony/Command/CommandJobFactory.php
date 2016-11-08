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
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;

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
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * Constructor.
     *
     * @param CommandBuilder $commandBuilder
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct(CommandBuilder $commandBuilder, JobReportManagerInterface $reportManager)
    {
        $this->commandBuilder = $commandBuilder;
        $this->reportManager = $reportManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(JobConfigurationInterface $configuration)
    {
        $command = $this->commandBuilder->build($configuration->getParameter('symfony_command'));
        $job = new ShellJob($command);
        $job->setReportManager($this->reportManager);
        
        return $job;
    }
}
