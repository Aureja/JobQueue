<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Provider;

use Aureja\JobQueue\Model\JobConfigurationInterface;
use Aureja\JobQueue\Model\Manager\JobConfigurationManagerInterface;
use Aureja\JobQueue\Register\JobFactoryRegistry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:13 PM
 */
class JobProvider implements JobProviderInterface
{

    /**
     * @var JobConfigurationManagerInterface
     */
    private $configurationManager;

    /**
     * @var JobFactoryRegistry
     */
    private $factoryRegistry;

    /**
     * Constructor.
     *
     * @param JobConfigurationManagerInterface $configurationManager
     * @param JobFactoryRegistry $factoryRegistry
     */
    public function __construct(
        JobConfigurationManagerInterface $configurationManager,
        JobFactoryRegistry $factoryRegistry
    ) {
        $this->configurationManager = $configurationManager;
        $this->factoryRegistry = $factoryRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getFactory(JobConfigurationInterface $configuration)
    {
        return $this->factoryRegistry->getFactory($configuration->getFactory());
    }

    /**
     * {@inheritdoc}
     */
    public function getFactoryNames()
    {
        return array_keys($this->factoryRegistry->getFactories());
    }

    /**
     * {@inheritdoc}
     */
    public function getNextConfiguration($queue)
    {
        return $this->configurationManager->findNext($queue);
    }
}
