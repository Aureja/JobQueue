<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Php;

use Aureja\JobQueue\JobFactoryInterface;
use Aureja\JobQueue\Model\JobConfigurationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/21/15 12:12 AM
 */
class PhpJobFactory implements JobFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function create(JobConfigurationInterface $configuration)
    {
        return new PhpJob($configuration->getParameter('php_script'));
    }
}
