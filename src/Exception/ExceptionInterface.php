<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Exception;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/21/15 12:10 AM
 */
interface ExceptionInterface
{
    /**
     * Create exception.
     *
     * @param string $message
     *
     * @return static
     */
    public static function create($message);
}
