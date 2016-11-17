<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests;

use DCS\PasswordReset\Persistence\ORMBundle\DCSPasswordResetPersistenceORMBundle;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DCSPasswordResetPersistenceORMBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildAddsProviderCompilerPass()
    {
        $containerBuilder = $this->createMock(ContainerBuilder::class);
        $containerBuilder->expects($this->atLeastOnce())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(DoctrineOrmMappingsPass::class));

        $bundle = new DCSPasswordResetPersistenceORMBundle();
        $bundle->build($containerBuilder);
    }
}