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

use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Model\JobConfigurationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:12 PM
 */
interface JobProviderInterface
{

    /**
     * Get job factory.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobFactoryInterface
     */
    public function getFactory(JobConfigurationInterface $configuration);

    /**
     * Get job factory names.
     *
     * @return array
     */
    public function getFactoryNames();

    /**
     * Get next job configuration.
     *
     * @param string $queue
     *
     * @return null|JobConfigurationInterface
     */
    public function getNextConfiguration($queue);
}
