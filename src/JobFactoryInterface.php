<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue;

use Aureja\JobQueue\Model\JobConfigurationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/17/15 12:14 AM
 */
interface JobFactoryInterface
{

    /**
     * Create job.
     *
     * @param JobConfigurationInterface $configuration
     *
     * @return JobInterface
     */
    public function create(JobConfigurationInterface $configuration);
}
