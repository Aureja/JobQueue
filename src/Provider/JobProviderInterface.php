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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:12 PM
 */
interface JobProviderInterface
{
    public function getNextJob($queue);
}
