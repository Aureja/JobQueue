<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue\DependencyInjection\Compiler;

use Aureja\JobQueue\Exception\JobFactoryException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/20/15 10:06 PM
 */
class RegisterJobFactoriesPass implements CompilerPassInterface
{

    /**
     * @var string
     */
    private $factoryTag;

    /**
     * @var string
     */
    private $registryService;

    /**
     * Constructor.
     *
     * @param string $registryService
     * @param string $factoryTag
     */
    public function __construct(
        $registryService = 'aureja_job_queue.registry.job_factory',
        $factoryTag = 'aureja_job_factory'
    ) {
        $this->registryService = $registryService;
        $this->factoryTag = $factoryTag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->registryService)) {
            return null;
        }

        $definition = $container->getDefinition($this->registryService);

        foreach ($container->findTaggedServiceIds($this->factoryTag) as $id => $tags) {
            if (false === isset($tags[0]['alias'])) {
                throw new JobFactoryException('Job factory %s service without tag!', $id);
            }

            $definition->addMethodCall('add', [new Reference($id), $tags[0]['alias']]);
        }
    }
}
