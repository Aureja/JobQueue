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

use RuntimeException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/5/16 7:25 PM
 */
abstract class AbstractException extends RuntimeException implements ExceptionInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create($message)
    {
        return new static($message);
    }
}
