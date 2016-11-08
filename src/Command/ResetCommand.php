<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Command;

use Aureja\JobQueue\JobQueue;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/29/15 10:22 PM
 */
class ResetCommand extends Command
{
    /**
     * @var JobQueue
     */
    private $jobQueue;

    /**
     * Constructor.
     *
     * @param JobQueue $jobQueue
     */
    public function __construct(JobQueue $jobQueue)
    {
        parent::__construct();

        $this->jobQueue = $jobQueue;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('aureja:job-queue:reset')
            ->setDescription('Reset jobs from the queue.')
            ->addArgument('queue', InputArgument::OPTIONAL, 'Reset job from current queue.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->jobQueue->reset($input->getArgument('queue'));
    }
}
