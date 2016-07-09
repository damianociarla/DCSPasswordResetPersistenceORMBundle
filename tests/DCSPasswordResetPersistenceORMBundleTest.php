<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests;

use DCS\PasswordReset\Persistence\ORMBundle\DCSPasswordResetPersistenceORMBundle;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DCSPasswordResetPersistenceORMBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testDoctrineOrmMappingsPass()
    {
        $bundle = new DCSPasswordResetPersistenceORMBundle();

        $container = new ContainerBuilder();

        $bundle->build($container);

        $isContains = false;

        foreach ($container->getCompiler()->getPassConfig()->getPasses() as $compilerPass) {
            if ($compilerPass instanceof DoctrineOrmMappingsPass) {
                $isContains = true;
            }
        }

        $this->assertTrue($isContains, 'Doctrine bundle is not loaded in your composer.json');
    }
}