Checkers
========

Checkers will verify claims and headers key/value of all JWSInterface objects.

Each Checker you create is available as a service you can inject in your own services or use from the container.
It will check the claims in the payload (if any) and headers you explicitly defined.

In the following example, we create a checker that will be available through `jose.encrypter.CHECKER1`:

```yml
jose:
    checkers:
        CHECKER1: # ID of the Signer. Must be unique
            is_public: true # The service created by the bundle will be public (default)
            claim_checkers: # This checker will check the following claims
                - 'exp' # Expiration claim
                - 'iat' # Issued at claim
                - 'nbf' # Not Before claim
            header_checkers: # This checker will check the following headers
                - 'crit' # Critical header
```
