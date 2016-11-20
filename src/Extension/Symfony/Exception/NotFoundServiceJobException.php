<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Symfony\Exception;

use Aureja\JobQueue\Exception\ExceptionInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 11:43 PM
 */
class NotFoundServiceJobException extends \RuntimeException implements ExceptionInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create($message)
    {
        return new self($message);
    }
}
