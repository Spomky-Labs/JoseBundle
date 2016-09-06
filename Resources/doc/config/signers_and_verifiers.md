Signers and Verifiers Services
==============================

# Signers

A Signer is a service that provides functions to sign payloads according to the headers (protected or unprotected) and private or shared keys.

Each Signer you create is available as a service you can inject in your own services or use from the container. It is allowed to use a set of algorithms you explicitly defined.

In the following example, we create two Signers. They will be available through `jose.signer.SIGNER1` and `jose.signer.SIGNER2` respectively:

```yml
jose:
    signers:
        SIGNER1: # ID of the Signer. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            algorithms: # A list of algorithms
                - 'HS256'
                - 'HS384'
                - 'HS512'
        SIGNER2: # ID of the Signer. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            algorithms: # A list of algorithms
                - 'RS256'
                - 'RS512'
                - 'PS256'
                - 'PS512'
```

# Verifiers

A Verifier is a service that provides functions to verify the JWS you received using public or shared keys.

As Signers, each Verifier you create is available as a service you can inject in your own services or use from the container. It is allowed to use a set of algorithms you explicitly defined.

In the following example, we create one Verifier. It will be available through `jose.verifier.VERFIER1`:

```yml
jose:
    verifiers:
        VERFIER1: # ID of the Verifier. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            algorithms: # A list of algorithms
                - 'HS256'
                - 'HS384'
                - 'HS512'
```
