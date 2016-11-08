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

use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/21/15 12:14 AM
 */
class ShellJobFactory implements JobFactoryInterface
{

    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * Constructor.
     *
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct(JobReportManagerInterface $reportManager)
    {
        $this->reportManager = $reportManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(JobConfigurationInterface $configuration)
    {
        $job = new ShellJob($configuration->getParameter('shell_command'));
        $job->setReportManager($this->reportManager);
        
        return $job;
    }
}
