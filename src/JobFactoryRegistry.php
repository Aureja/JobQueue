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

use Aureja\JobQueue\Exception\JobFactoryException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 10:09 PM
 */
class JobFactoryRegistry
{
    /**
     * @var array|JobFactoryInterface[]
     */
    private $factories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->factories = [];
    }

    /**
     * Add factory.
     *
     * @param JobFactoryInterface $factory
     * @param string $name
     */
    public function add(JobFactoryInterface $factory, $name)
    {
        $this->factories[$name] = $factory;
    }

    /**
     * Get factory.
     *
     * @param string $name
     *
     * @return JobFactoryInterface
     *
     * @throws JobFactoryException
     */
    public function get($name)
    {
        if (isset($this->factories[$name])) {
            return $this->factories[$name];
        }

        throw JobFactoryException::create(sprintf('Not found %s job factory', $name));
    }

    /**
     * Get factories.
     *
     * @return array|JobFactoryInterface[]
     */
    public function all()
    {
        return $this->factories;
    }

    /**
     * Get register factories names.
     *
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->factories);
    }
}
