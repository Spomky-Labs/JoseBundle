<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\JoseBundle\DependencyInjection\Source\JWKSetSource;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class X5U implements JWKSetSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = new Definition('Jose\Object\JWKSet');
        $definition->setFactory([
            new Reference('jose.factory.jwk'),
            'createFromX5U',
        ]);
        $definition->setArguments([
            $config['url'],
            $config['is_secured'],
            $config['cache'],
            $config['cache_ttl'],
        ]);
        $definition->setPublic($config['is_public']);

        $container->setDefinition($id, $definition);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeySet()
    {
        return 'x5u';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->booleanNode('is_public')
                    ->info('If true, the service will be public, else private.')
                    ->defaultTrue()
                ->end()
                ->scalarNode('url')->isRequired()->end()
                ->booleanNode('is_secured')->defaultTrue()->end()
                ->scalarNode('cache')->defaultNull()->end()
                ->integerNode('cache_ttl')->defaultValue(0)->end()
            ->end();
    }
}
