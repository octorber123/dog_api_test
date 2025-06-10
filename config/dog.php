<?php

return [
    'base_uri'   => env('DOG_API_BASE_URI', 'https://dog.ceo/api'),
    //DIDNT HAVE TIME TO IMPLEMENT, BUT WOULD BE USED TO CACHE API RESPONSES FROM THE DOG API IF ITS RATE WAS LIMITED
    'cache_ttl'  => env('DOG_API_CACHE_TTL', 60)
];
