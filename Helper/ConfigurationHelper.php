<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\JoseBundle\Helper;

use Assert\Assertion;

/**
 * This helper will help you to create services configuration.
 */
final class ConfigurationHelper
{
    /**
     * @param string   $name
     * @param string[] $header_checkers
     * @param string[] $claim_checkers
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getCheckerConfiguration($name, array $header_checkers, array $claim_checkers, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::allString($header_checkers);
        Assertion::allString($claim_checkers);

        return [
            'jose' => [
                'checkers' => [
                    $name => [
                        'is_public' => $is_public,
                        'claims'    => $claim_checkers,
                        'headers'   => $header_checkers,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string   $name
     * @param string[] $signature_algorithms
     * @param bool     $create_verifier
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getSignerConfiguration($name, array $signature_algorithms, $create_verifier = false, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::allString($signature_algorithms);
        Assertion::notEmpty($signature_algorithms);
        Assertion::boolean($create_verifier);

        return [
            'jose' => [
                'signers' => [
                    $name => [
                        'is_public'       => $is_public,
                        'algorithms'      => $signature_algorithms,
                        'create_verifier' => $create_verifier,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string   $name
     * @param string[] $signature_algorithms
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getVerifierConfiguration($name, array $signature_algorithms, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::allString($signature_algorithms);
        Assertion::notEmpty($signature_algorithms);

        return [
            'jose' => [
                'verifiers' => [
                    $name => [
                        'is_public'  => $is_public,
                        'algorithms' => $signature_algorithms,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string   $name
     * @param string[] $key_encryption_algorithms
     * @param string[] $content_encryption_algorithms
     * @param string[] $compression_methods
     * @param bool     $create_decrypter
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getEncrypterConfiguration($name, array $key_encryption_algorithms, array $content_encryption_algorithms, array $compression_methods = ['DEF'], $create_decrypter = false, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::allString($key_encryption_algorithms);
        Assertion::notEmpty($key_encryption_algorithms);
        Assertion::allString($content_encryption_algorithms);
        Assertion::notEmpty($content_encryption_algorithms);
        Assertion::boolean($create_decrypter);

        return [
            'jose' => [
                'encrypters' => [
                    $name => [
                        'is_public'                     => $is_public,
                        'key_encryption_algorithms'     => $key_encryption_algorithms,
                        'content_encryption_algorithms' => $content_encryption_algorithms,
                        'compression_methods'           => $compression_methods,
                        'create_decrypter'              => $create_decrypter,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string   $name
     * @param string[] $key_encryption_algorithms
     * @param string[] $content_encryption_algorithms
     * @param string[] $compression_methods
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getDecrypterConfiguration($name, array $key_encryption_algorithms, array $content_encryption_algorithms, array $compression_methods = ['DEF'], $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::allString($key_encryption_algorithms);
        Assertion::notEmpty($key_encryption_algorithms);
        Assertion::allString($content_encryption_algorithms);
        Assertion::notEmpty($content_encryption_algorithms);

        return [
            'jose' => [
                'decrypters' => [
                    $name => [
                        'is_public'                     => $is_public,
                        'key_encryption_algorithms'     => $key_encryption_algorithms,
                        'content_encryption_algorithms' => $content_encryption_algorithms,
                        'compression_methods'           => $compression_methods,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string      $name
     * @param string      $signer
     * @param string|null $encrypter
     * @param bool        $is_public
     *
     * @return array
     */
    public static function getJWTCreatorConfiguration($name, $signer, $encrypter = null, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::string($signer);
        Assertion::notEmpty($signer);
        Assertion::nullOrString($encrypter);

        return [
            'jose' => [
                'jwt_creators' => [
                    $name => [
                        'is_public' => $is_public,
                        'signer'    => $signer,
                        'encrypter' => $encrypter,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string      $name
     * @param string      $verifier
     * @param string      $checker
     * @param string|null $decrypter
     * @param bool        $is_public
     *
     * @return array
     */
    public static function getJWTLoaderConfiguration($name, $verifier, $checker, $decrypter = null, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::string($verifier);
        Assertion::notEmpty($verifier);
        Assertion::string($checker);
        Assertion::notEmpty($checker);
        Assertion::nullOrString($decrypter);

        return [
            'jose' => [
                'jwt_loaders' => [
                    $name => [
                        'is_public' => $is_public,
                        'verifier'  => $verifier,
                        'checker'   => $checker,
                        'decrypter' => $decrypter,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $name
     * @param int    $nb_keys
     * @param array  $key_configuration
     * @param bool   $is_rotatable
     * @param bool   $is_public
     *
     * @return array
     */
    public static function getRandomJWKSetConfiguration($name, $nb_keys, array $key_configuration, $is_rotatable = false, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::integer($nb_keys);
        Assertion::greaterThan($nb_keys, 0);
        Assertion::boolean($is_rotatable);

        return [
            'jose' => [
                'key_sets' => [
                    $name => [
                        'auto' => [
                            'is_rotatable'      => $is_rotatable,
                            'is_public'         => $is_public,
                            'nb_keys'           => $nb_keys,
                            'key_configuration' => $key_configuration,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $name
     * @param string $jwkset
     * @param bool   $is_public
     *
     * @return array
     */
    public static function getPublicJWKSetConfiguration($name, $jwkset, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::string($jwkset);
        Assertion::notEmpty($jwkset);

        return [
            'jose' => [
                'key_sets' => [
                    $name => [
                        'public_jwkset' => [
                            'is_public' => $is_public,
                            'id'        => $jwkset,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string   $name
     * @param string[] $jwksets
     * @param bool     $is_public
     *
     * @return array
     */
    public static function getJWKSetsConfiguration($name, array $jwksets, $is_public = true)
    {
        self::checkParameters($name, $is_public);
        Assertion::isArray($jwksets);
        Assertion::allString($jwksets);
        Assertion::allNotEmpty($jwksets);

        return [
            'jose' => [
                'key_sets' => [
                    $name => [
                        'jwksets' => [
                            'is_public' => $is_public,
                            'id'        => $jwksets,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $name
     * @param bool   $is_public
     */
    private static function checkParameters($name, $is_public)
    {
        Assertion::string($name);
        Assertion::notEmpty($name);
        Assertion::boolean($is_public);
    }
}
