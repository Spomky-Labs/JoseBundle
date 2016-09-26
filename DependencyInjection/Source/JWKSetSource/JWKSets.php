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

class JWKSets implements JWKSetSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = new Definition('Jose\Object\JWKSet');
        $definition->setFactory([
            new Reference('jose.factory.jwk'),
            'createKeySets',
        ]);
        foreach ($config['id'] as $key_set_id) {
            $ref = new Reference($key_set_id);
            $definition->addMethodCall('addKeySet', [$ref]);
        }
        $definition->setPublic($config['is_public']);
        $container->setDefinition($id, $definition);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeySet()
    {
        return 'jwksets';
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
                ->arrayNode('id')
                    ->prototype('scalar')->end()
                    ->isRequired()
                ->end()
            ->end();
    }
}
