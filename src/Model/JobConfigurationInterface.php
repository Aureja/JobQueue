<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:17 PM
 */
interface JobConfigurationInterface
{

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return JobConfigurationInterface
     */
    public function setEnabled($enabled);

    /**
     * Checks or is enabled.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Set auto restorable.
     *
     * @param bool $autoRestorable
     *
     * @return JobConfigurationInterface
     */
    public function setAutoRestorable($autoRestorable);

    /**
     * Checks or is auto restorable.
     *
     * @return bool
     */
    public function isAutoRestorable();

    /**
     * Set factory.
     *
     * @param string $factory
     *
     * @return JobConfigurationInterface
     */
    public function setFactory($factory);

    /**
     * Get factory.
     *
     * @return string
     */
    public function getFactory();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return JobConfigurationInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set next start.
     *
     * @param null|\DateTime $nextStart
     *
     * @return JobConfigurationInterface
     */
    public function setNextStart(\DateTime $nextStart = null);

    /**
     * Get next start.
     *
     * @return null|\DateTime
     */
    public function getNextStart();

    /**
     * Set parameters.
     *
     * @param array $parameters
     *
     * @return JobConfigurationInterface
     */
    public function setParameters(array $parameters);

    /**
     * Get parameter.
     *
     * @param string $key
     *
     * @return string
     */
    public function getParameter($key);

    /**
     * Get parameters.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Add parameter.
     *
     * @param string $key
     * @param string $parameter
     */
    public function addParameter($key, $parameter);

    /**
     * Remove parameter.
     *
     * @param $key
     */
    public function removeParameter($key);

    /**
     * Set period.
     *
     * @param int $period
     *
     * @return JobConfigurationInterface
     */
    public function setPeriod($period);

    /**
     * Get period.
     *
     * @return int
     */
    public function getPeriod();

    /**
     * Set order nr.
     *
     * @param int $orderNr
     *
     * @return JobConfigurationInterface
     */
    public function setOrderNr($orderNr);

    /**
     * Get order nr.
     *
     * @return int
     */
    public function getOrderNr();

    /**
     * Set queue.
     *
     * @param string $queue
     *
     * @return JobConfigurationInterface
     */
    public function setQueue($queue);

    /**
     * Get queue.
     *
     * @return string
     */
    public function getQueue();

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return JobConfigurationInterface
     */
    public function setState($state);

    /**
     * Get state.
     *
     * @return string
     */
    public function getState();
}
