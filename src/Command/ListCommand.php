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

use Aureja\JobQueue\Model\Manager\JobConfigurationManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/29/15 10:19 PM
 */
class ListCommand extends Command
{
    /**
     * @var JobConfigurationManagerInterface
     */
    private $configurationManager;

    /**
     * Constructor.
     *
     * @param JobConfigurationManagerInterface $configurationManager
     */
    public function __construct(JobConfigurationManagerInterface $configurationManager)
    {
        parent::__construct();

        $this->configurationManager = $configurationManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('aureja:job-queue:list')
            ->setDescription('Show jobs.')
            ->addArgument('queue', InputArgument::OPTIONAL)
        ;
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurations = $this->configurationManager->getConfigurations($input->getArgument('queue'));
        $rows = [];

        foreach ($configurations as $configuration) {
            $rows[] = [
                $configuration->getQueue(),
                $configuration->getState(),
                $configuration->getName(),
                $configuration->isEnabled() ? 'Yes' : 'No',
                $configuration->getPeriod() . 's',
                $configuration->getNextStart() ? $configuration->getNextStart()->format('Y-m-d H:i:s') : null,
                $configuration->getFactory(),
                json_encode($configuration->getParameters()),
            ];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Queue', 'State', 'Name', 'Enabled', 'Period', 'Next start', 'Factory', 'Parameters'])
            ->setRows($rows);

        $table->render();
    }
}
