<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension;

use Symfony\Component\Process\PhpExecutableFinder;

final class PhpUtils
{
    private static $phpExecutable;

    /**
     * @return string
     */
    public static function getPhp()
    {
        if (null === self::$phpExecutable) {
            $finder = new PhpExecutableFinder();
            
            self::$phpExecutable = $finder->find();
        }

        return self::$phpExecutable;
    }
}
