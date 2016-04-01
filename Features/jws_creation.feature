Feature: This bundle provides a service able to create JWS

  Scenario: I can create a JWS in JSON Compact Serialization Mode
    Given I have the following values in the header
    """
    {
        "alg":"HS512"
    }
    """
    And I have the following payload
    """
    Hello World!
    """
    When I try to create a JWS in JSON Compact Serialization Mode with signature key "jose.key.key0" and I store the result in the variable "jws_compact"
    Then the variable "jws_compact" should be a string with value "eyJhbGciOiJIUzUxMiJ9.SGVsbG8gV29ybGQh.Q2THrV6jf_V9Ad-cMMkcMfagBhIME6OEOjxbksQSacDY591l9KKiaPv4aoiSk0wpqMftxE8LFJKc6qPz3nnaHQ"
