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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:13 PM
 */
class JobProvider implements JobProviderInterface
{

    /**
     * @var JobConfigurationInterface
     */
    private $configurationManager;

    /**
     * Constructor.
     *
     * @param JobConfigurationInterface $configurationManager
     */
    public function __construct(JobConfigurationInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextJob($queue)
    {
        // TODO: Implement getNextJob() method.
    }
}
