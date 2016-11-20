<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Symfony\Command;

use Aureja\JobQueue\Extension\PhpUtils;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/17/15 12:08 AM
 */
class CommandBuilder
{
    /**
     * @var string
     */
    private $consoleDir;

    /**
     * @var string
     */
    private $environment;

    /**
     * Constructor.
     *
     * @param string $environment
     * @param $consoleDir
     */
    public function __construct($consoleDir, $environment)
    {
        $this->consoleDir = rtrim($consoleDir, '/');
        $this->environment = $environment;
    }

    /**
     * Build command.
     *
     * @param string $command
     *
     * @return string
     */
    public function build($command)
    {
        return sprintf(
            '%s %s/%s %s --env=%s --no-debug',
            PhpUtils::getPhp(),
            $this->consoleDir,
            'console',
            $command,
            $this->environment
        );
    }
}
