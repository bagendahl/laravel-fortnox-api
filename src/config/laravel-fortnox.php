<?php

return [
    'fortnox_client_secret' => env('FORTNOX_CLIENT_SECRET'),
    'fortnox_client_id' => env('FORTNOX_CLIENT_ID'),
    'fortnox_access_token' => env('FORTNOX_ACCESS_TOKEN'),
    'default_query_limit' => 500, // may not exceed 500
    'base_uri' => 'https://api.fortnox.se/3',
];
