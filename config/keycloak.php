<?php

return [
  'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAk0byyaYIH1kJPRVE74kFIjAp/9e5QXlcAwfIkNi4G/SMlYHWaN+ZoJVZJMG0SqNsivB+mVqxdxR2ZqPX4giQGFuYV7ySfJENmPjH1M9vH6P+Ddd1CfG4u44XVrQKLGV0EQKgIBB3a5rNmSo3vRncAbGzorqWsVJoqZzxCqOtHoTTvZwTix+apSpv/imz9R55aBcMjF1fwAwf0GANgIijIvddrMEGtJpMQ1tiP2uvf1lb0I5n91vyLqGFrsUdi+xYMGgqpcejIVNyYNpyxXllZFCa1ydmG6zseRa/FjCDDvzovXUcpkAliPDNqiIBLCiZ3Kgych3JvwxJBu1Hn0Sz+wIDAQAB'),

  'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),

  'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),

  'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', false),

  'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES', 'teste1,account')
];
