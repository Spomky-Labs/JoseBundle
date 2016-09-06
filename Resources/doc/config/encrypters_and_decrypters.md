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

# Decrypters

A Decrypter is a service that provides functions to decrypt JWE you received using private or shared keys.

As Encrypters, each Decrypter you create is available as a service you can inject in your own services or use from the container. It is allowed to use a set of algorithms you explicitly defined.

In the following example, we create a Decrypter. It will be available through `jose.verifier.DECRYPTER1`:

```yml
jose:
    decrypters:
        DECRYPTER1: # ID of the Decrypter. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            key_encryption_algorithms: # A list of algorithms used for the encryption of the key
                - '128GCMKW'
                - 'A256GCMKW'
                - 'RSA-OAEP'
            content_encryption_algorithms: # A list of algorithms used for the encryption of the content
                - 'A128GCM'
                - 'A256GCM'
```
