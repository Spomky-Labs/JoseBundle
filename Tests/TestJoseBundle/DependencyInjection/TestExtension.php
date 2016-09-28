<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\TestJoseBundle\DependencyInjection;

use SpomkyLabs\JoseBundle\Helper\ConfigurationHelper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class TestExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }


    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        ConfigurationHelper::addChecker($container, 'test', ['crit'], ['iat', 'nbf', 'exp'], true);
        ConfigurationHelper::addRandomJWKSet($container, 'from_configuration_helper', '%kernel.cache_dir%/from_configuration_helper.keyset', 2, ['kty'=>'RSA', 'size'=>1024], true, true);

    }
}
