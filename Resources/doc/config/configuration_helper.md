# Bundle Integration

This bundle may be used by other bundles to provide JWT support.
If your are in that case, then you will have to configure your bundle and the JoseBundle and your configuration file will become too verbose.

That is why this bundle provides a [`ConfigurationHelper`](../../Helper/ConfigurationHelper.php) that will help your to modify the configuration of JoseBundle from your bundle.

Let say you have a bundle that need a key set, a decrypter, a verfier and a claim checker to load and verify encrypted JWS.
Your public keys are share to allow third party applications to send you those JWT.

Normally your configuration file should be something like that one:

```yml
...
# You bundle configuration
my_bundle:
    private_keys: 'jose.key_set.all_keys'
    public_keys: 'jose.key_set.all_public_keys'
    jwt_loader: 'jose.jwt_loader.main'

# The JoseBundle configuration
jose:
    easy_jwt_loader:
        main:
            signature_algorithms:
                - 'RS256'
            key_encryption_algorithms:
                - 'RSA-OAEP-256'
            content_encryption_algorithms:
                - 'A256GCM'
            claim_checkers:
                - 'exp'
                - 'iat'
                - 'nbf'
            header_checkers:
                - 'crit'
    key_sets:
        signature_keys:
            auto:
                storage_path: "%kernel.cache_dir%/signature_keys.keyset"
                is_rotatable: true
                nb_keys: 2
                key_configuration:
                    kty: 'RSA'
                    size: 4096
                    alg: "RS256"
                    use: "sig"
        encryption_keys:
            auto:
                storage_path: "%kernel.cache_dir%/encryption_keys.keyset"
                is_rotatable: true
                nb_keys: 2
                key_configuration:
                    kty: 'RSA'
                    size: 4096
                    alg: "RSA-OAEP-256"
                    use: "enc"
        all_keys:
            jwksets:
                id:
                    - 'jose.key_set.signature_keys'
                    - 'jose.key_set.encryption_keys'
        all_public_keys:
            public_jwkset:
                id: 'jose.key_set.all_keys'
```

As you can see the configuration file is too heavy for the job to do.
Let's shrink all to lines.

**To Be Continued**
