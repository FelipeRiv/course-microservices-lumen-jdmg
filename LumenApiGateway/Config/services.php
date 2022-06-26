<?php
// The main idea is to get the base url to make requests depending on the service we need and those url are in the .env file so we dont need to change the url in the code just in the env file in case we needed to

// base_uri is the one -> traid ConsumeExternalService.php is using, that traig is linked to this file and is going to get base_uri in this array

return [
    'authors' => [
        'base_uri' => env('AUTHORS_SERVICE_BASE_URL'),
        'secret' => env('AUTHORS_SERVICE_SECRET'),
    ],

    'books' => [
        'base_uri' => env('BOOKS_SERVICE_BASE_URL'),
        'secret' => env('BOOKS_SERVICE_SECRET'),
    ],

];