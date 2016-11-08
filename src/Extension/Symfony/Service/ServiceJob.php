<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\Extension\Symfony\Service;

use Aureja\JobQueue\Extension\Symfony\Exception\NotFoundServiceJobException;
use Aureja\JobQueue\JobInterface;
use Aureja\JobQueue\JobState;
use Aureja\JobQueue\JobTrait;
use Aureja\JobQueue\Model\JobReportInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 10:38 PM
 */
class ServiceJob implements JobInterface
{
    use JobTrait;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $method;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     * @param string $id
     * @param string $method
     */
    public function __construct(ContainerInterface $container, $id, $method)
    {
        $this->id = $id;
        $this->method = $method;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function run(JobReportInterface $report)
    {
        if (false === $this->container->has($this->id)) {
            throw NotFoundServiceJobException::create(sprintf('Not found %s service', $this->id));
        }

        $service = $this->container->get($this->id);

        if (false === method_exists($service, $this->method)) {
            throw NotFoundServiceJobException::create(sprintf('Not found %s service %s method', $this->id, $this->method));
        }

        try {
            $this->savePid(posix_getpid(), $report);
            // TODO: array, object serialize???
            $report->setOutput($service->{$this->method}());
        } catch (\Exception $e) {
            $report->setErrorOutput($e->getMessage());

            return JobState::STATE_FAILED;
        }

        return JobState::STATE_FINISHED;
    }
}
