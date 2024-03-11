<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\Functional;

use FOS\MessageBundle\Tests\Functional\EntityManager\MessageManager;
use FOS\MessageBundle\Tests\Functional\EntityManager\ThreadManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisteringManagersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->register('fos_message.message_manager.default', MessageManager::class);
        $container->register('fos_message.thread_manager.default', ThreadManager::class);
    }
}