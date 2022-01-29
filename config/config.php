<?php

return [
    // To disable specific file creation set it to false.
    'create_resource' => true,
    'create_service' => true,
    'create_requests' => true,
    'create_repository' => true,
    'create_controller' => true,
    'create_test' => true,

    // API versioning.
    'version' => 'v1',

    /**
     * List of instances that should ignore versioning. Available:
     *
     *  - controllers
     *  - models
     *  - repositories
     *  - resources
     *  - requests
     *  - services
     *
     */
    'versioning_disabled_for' => ['models'],

    // The api route file path to autoimport resource routes.
    'api_file_path' => '/routes/api.php'
];