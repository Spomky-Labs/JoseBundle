Encrypters and Decrypters Services
==================================

# Encrypters

An Encrypter is a service that provides methods to encrypt payloads according to the headers (protected or unprotected) and public or shared keys.

Each Encrypter you create is available as a service you can inject in your own services or use from the container. It is allowed to use a set of algorithms you explicitly defined.

In the following example, we create an Encrypter that will be available through `jose.encrypter.ENCRYPTER1`:

```yml
jose:
    encrpters:
        ENCRYPTER1: # ID of the Signer. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            key_encryption_algorithms: # A list of algorithms used for the encryption of the key
                - '128GCMKW'
                - 'A256GCMKW'
                - 'RSA-OAEP'
            content_encryption_algorithms: # A list of algorithms used for the encryption of the content
                - 'A128GCM'
                - 'A256GCM'
```

Now you will be able to encrypt payloads (claims or messages) using these services:

```php
use Jose\Factory\JWEFactory;

// We get the key of the recipient (we suppose that MY_KEY1 is a valid key)
$key = $container->get('jose.key.MY_KEY1');
$encrypter = $container->get('jose.encrypter.ENCRYPTER1'); // Only if the service is public

// The payload to sign
$payload = 'Hello World!';

// We have to create a JWE class using the JWEFactory.
// The payload of this object contains our message.
$jwe = JWEFactory::createJWE(
    $payload,                 // The payload
    [                         // The shared protected header
        'enc' => 'A128GCM',   // The content encryption algorithm
        'alg' => 'A256GCMKW', // The key encryption algorithm
        'zip' => 'DEF',       // We want to compress the payload before encryption (not mandatory, but useful for a large payload
    ]
);

// We add the recipient public key.
$jwe = $jwe->addRecipientInformation(key1);

// We sign it
$encrypter->encrypt($jwe);

//We can get the Compact, Flattened or General Serialization Representation of that JWE
// 0 is the recipient index (the first recipient in this case)
$jwe->toCompactJSON(0);
$jwe->toFlattenedJSON(0);
$jwe->toJSON();
```

# Decrypters

A Decrypter is a service that provides functions to decrypt JWE you received using private or shared keys.

As Encrypters, each Decrypter you create is available as a service you can inject in your own services or use from the container. It is allowed to use a set of algorithms you explicitly defined.

In the following example, we create two Decrypters. They will be available through `jose.verifier.DECRYPTER1` and `jose.verifier.DECRYPTER2` respectively:

```yml
jose:
    decrypters:
        DECRYPTER1: # ID of the Decrypter. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            algorithms: # A list of algorithms
                - 'HS256'
                - 'HS384'
                - 'HS512'
        DECRYPTER2: # ID of the Decrypter. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            algorithms: # A list of algorithms
                - 'RS256'
                - 'RS512'
                - 'PS256'
                - 'PS512'
```

Now you will be able to verify JWE using these services. Please note a Decrypter verifies the signatures, not the claims of the JWE.

```php
// To be written
```
