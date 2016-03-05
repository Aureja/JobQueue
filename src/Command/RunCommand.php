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
 * @since 4/20/15 10:26 PM
 */
class RunCommand extends Command
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
        $this->jobQueue = $jobQueue;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('aureja:job-queue:run')
            ->setDescription('Runs jobs from the queue.')
            ->addArgument('queue', InputArgument::OPTIONAL, 'Run job from current queue.')
        ;
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->jobQueue->run($input->getArgument('queue'));
    }
}
