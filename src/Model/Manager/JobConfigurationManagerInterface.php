<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Model\Manager;

use Aureja\JobQueue\Model\JobConfigurationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:09 PM
 */
interface JobConfigurationManagerInterface
{

    /**
     * Find job configuration by id.
     *
     * @param int $id
     *
     * @return null|JobConfigurationInterface
     */
    public function find($id);

    /**
     * Find all job configurations.
     *
     * @return array|JobConfigurationInterface[]
     */
    public function findAll();

    /**
     * Find job configuration by name.
     *
     * @param string $name
     *
     * @return null|JobConfigurationInterface
     */
    public function findByName($name);

    /**
     * Find job configuration by queue and state.
     *
     * @param string $queue
     * @param string $state
     *
     * @return null|JobConfigurationInterface
     */
    public function findByQueueAndState($queue, $state);

    /**
     * Find potential dead job configurations.
     *
     * @param string $queue
     *
     * @return array|JobConfigurationInterface[]
     */
    public function findPotentialDeadJobs($queue);

    /**
     * Find next job configuration.
     *
     * @param string $queue
     *
     * @return null|JobConfigurationInterface
     */
    public function findNextByQueue($queue);

    /**
     * Get job configurations.
     *
     * @param null|string $queue
     *
     * @return JobConfigurationInterface[]
     */
    public function getConfigurations($queue = null);

    /**
     * Create new job configuration object.
     *
     * @return JobConfigurationInterface
     */
    public function create();

    /**
     * Add job configuration object to persistent layer.
     *
     * @param JobConfigurationInterface $configuration
     * @param bool $save
     */
    public function add(JobConfigurationInterface $configuration, $save = false);

    /**
     * Remove job configuration object from persistent layer.
     *
     * @param JobConfigurationInterface $configuration
     * @param bool $save
     */
    public function remove(JobConfigurationInterface $configuration, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear job configuration objects from persistent layer.
     */
    public function clear();

    /**
     * Get job configuration object class name.
     *
     * @return string
     */
    public function getClass();
}
