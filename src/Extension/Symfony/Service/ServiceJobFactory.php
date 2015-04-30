<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Symfony\Service;

use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\Manager\JobReportManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:40 PM
 */
class ServiceJobFactory implements JobFactoryInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var JobReportManagerInterface
     */
    private $reportManager;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     * @param JobReportManagerInterface $reportManager
     */
    public function __construct(ContainerInterface $container, JobReportManagerInterface $reportManager)
    {
        $this->container = $container;
        $this->reportManager = $reportManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(JobConfigurationInterface $configuration)
    {
        return new ServiceJob(
            $this->container,
            $configuration->getParameter('symfony_service_id'),
            $configuration->getParameter('symfony_service_method')
        );
    }
}
