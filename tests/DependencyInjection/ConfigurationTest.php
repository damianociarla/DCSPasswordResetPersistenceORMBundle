<?php

namespace DCS\PasswordReset\Persistence\ORMBundle\Tests\DependencyInjection;

use DCS\PasswordReset\Persistence\ORMBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\Config\Definition\ScalarNode;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new Configuration();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ConfigurationInterface::class, $this->configuration);
    }

    public function testGetConfigTreeBuilder()
    {
        $this->assertInstanceOf(TreeBuilder::class, $this->configuration->getConfigTreeBuilder());
    }

    public function testRootNodeNameBuilder()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $this->assertEquals('dcs_password_reset_persistence_orm', $treeBuilder->buildTree()->getName());
    }

    public function testAllNodes()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();

        /** @var \Symfony\Component\Config\Definition\ArrayNode $tree */
        $tree = $treeBuilder->buildTree();

        $this->assertCount(1, $children = $tree->getChildren());

        $this->assertArrayHasKey('manager', $children);
        $this->assertInstanceOf(ArrayNode::class, $children['manager']);

        $this->assertCount(1, $managerChildren = $children['manager']->getChildren());

        $this->assertArrayHasKey('save', $managerChildren);
        $this->assertInstanceOf(ScalarNode::class, $managerChildren['save']);
        $this->assertEquals('dcs_password_reset.persistence.orm.manager.save.default', $managerChildren['save']->getDefaultValue());
    }
}