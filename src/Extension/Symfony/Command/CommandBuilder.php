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

use Symfony\Component\Process\PhpExecutableFinder;

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
     * @var string
     */
    private $phpExecutable;

    /**
     * Constructor.
     *
     * @param string $environment
     * @param $consoleDir
     */
    public function __construct($consoleDir, $environment)
    {
        $this->consoleDir = $consoleDir;
        $this->environment = $environment;

        $finder = new PhpExecutableFinder();
        $this->phpExecutable = $finder->find();
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
            '%s %s/%s %s --env=%s',
            $this->phpExecutable,
            rtrim($this->consoleDir, '/'),
            'console',
            $command,
            $this->environment
        );
    }
}
