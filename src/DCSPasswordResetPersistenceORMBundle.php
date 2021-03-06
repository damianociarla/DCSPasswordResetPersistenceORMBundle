<?php

namespace DCS\PasswordReset\Persistence\ORMBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DCSPasswordResetPersistenceORMBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver([
                realpath(__DIR__ . '/Resources/config/doctrine-core') => 'DCS\PasswordReset\CoreBundle\Model',
            ])
        );
    }
}