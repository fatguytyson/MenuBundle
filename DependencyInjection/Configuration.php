<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace FGC\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    const CONFIG_KEY = 'fgc_menu.config';
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('fgc_menu');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->info('Menu structures for your menus.')
            ->defaultValue(array())
            ->useAttributeAsKey('group')
            ->arrayPrototype()
                ->info('Item display name and a way to call each menu easily.')
                ->useAttributeAsKey('name')
                ->arrayPrototype()
                ->children()
                    ->scalarNode('route')
                        ->info('Route Name to generate path or URL.')
                    ->end()
                    ->variableNode('routeOptions')
                        ->info('Route options if route needs it.')
                    ->end()
                    ->scalarNode('icon')
                        ->info('Icon name to add in dashboard menus.')
                    ->end()
                    ->integerNode('order')
                        ->min(0)
                        ->info('Order of the menu item so Annotations can be added in.')
                    ->end()
                    ->scalarNode('granted')
                        ->info('A single ROLE or ACTION to show only if is_granted() or none to always show.')
                    ->end()
                    ->variableNode('grantedObject')
                        ->info('Object for isGranted if needed.')
                    ->end()
                    ->scalarNode('children')
                        ->info('Menu name to place under this item.')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
