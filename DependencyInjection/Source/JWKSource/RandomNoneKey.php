<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\JoseBundle\DependencyInjection\Source\JWKSource;

class RandomNoneKey extends RandomKey
{
    /**
     * {@inheritdoc}
     */
    protected function getKeyConfig(array $config)
    {
        $values = $config['additional_values'];
        $values['kty'] = 'none';
        
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'none';
    }
}
