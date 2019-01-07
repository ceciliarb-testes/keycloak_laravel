<?php

return [
  'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsM8S144YQqG4S6KQDkw1KIprG6atJxufnCt8zKuDhfEETAEj7bXibhU+3NLsrMNpgraCs/A2bzFyN9s5fB5y7cTbOdA4xYDBfzWZVxY3lvrYZDC3zQugmkO3BPg/ZVuABv0gMpSyEJ9Dfvg+oKbpQa28hiZooKkbvh6Hl9xVR+FJqs+JS4bi7tmh/GfibDHEJQi9VNr2t2/BwQwAsaCpKJMvZ4+UEYz7I8mOdKoTyKiHfAC1skE7/ifiEz0Tr9nN7he+k4IwNVw5bPbPwfcpQCnn81BG87b+jho2fOWOsWfR+Lu6CBGPaT0Kpp0kgmHC1lUBxoKVKgzs31+4LpzP9QIDAQAB'),

  'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'email'),

  'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),

  'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', false),

  'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES', ['teste1'])
];
