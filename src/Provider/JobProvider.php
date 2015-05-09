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
use Aureja\JobQueue\Register\JobFactoryRegistry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:13 PM
 */
class JobProvider implements JobProviderInterface
{

    /**
     * @var JobFactoryRegistry
     */
    private $factoryRegistry;

    /**
     * Constructor.
     *
     * @param JobFactoryRegistry $factoryRegistry
     */
    public function __construct(JobFactoryRegistry $factoryRegistry)
    {
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
}
