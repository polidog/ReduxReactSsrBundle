<?php

namespace Polidog\ReduxReactSsrBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('polidog_redux_react_ssr');

        $rootNode->children()
            ->scalarNode('react_lib_src')->isRequired()->end()
            ->scalarNode('react_app_src')->isRequired()->end()
            ->scalarNode('default_template')->isRequired()->end()
            ->end();
        return $treeBuilder;
    }
}
