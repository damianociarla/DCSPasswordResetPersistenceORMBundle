<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class DCSPasswordResetPersistenceORMExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('manager.xml');
        $container->setAliases([
            'dcs_password_reset.persistence.orm.manager.save' => $config['manager']['save']
        ]);

        $loader->load('listener.xml');
        $loader->load('repository.xml');
    }
}