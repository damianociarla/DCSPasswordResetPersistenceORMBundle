<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\DependencyInjection;

use DCS\PasswordReset\Persistence\ORMBundle\DependencyInjection\DCSPasswordResetPersistenceORMExtension;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DCSPasswordResetPersistenceORMExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();

        $config = [
            'dcs_password_reset_persistence_orm' => [
                'manager' => [
                    'save' => 'acme.service'
                ],
            ],
        ];

        $mock = $this->getMockBuilder(DCSPasswordResetPersistenceORMExtension::class)->setMethods(['processConfiguration'])->getMock();
        $mock->load($config, $container);

        return $container;
    }

    /**
     * @depends testLoad
     */
    public function testContainsAliases(ContainerBuilder $container)
    {
        $this->assertTrue($container->hasAlias('dcs_password_reset.persistence.orm.manager.save'));
        $this->assertEquals('acme.service', $container->getAlias('dcs_password_reset.persistence.orm.manager.save'));
    }

    /**
     * @depends testLoad
     */
    public function testContainsLoadedXMLFiles(ContainerBuilder $container)
    {
        $this->assertCount(3, $resources = $container->getResources());

        /** @var FileResource $resource */
        foreach ($resources as $resource) {
            $this->assertContains(pathinfo($resource->getResource(), PATHINFO_BASENAME), ['manager.xml','listener.xml','repository.xml']);
        }
    }
}