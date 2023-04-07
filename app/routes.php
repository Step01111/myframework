<?php
return [
    ['/^$/', App\Controllers\MainController::class, 'main'],
    ['/^users\/registration$/',
        App\Controllers\UserController::class,
        'registration'
    ],
    ['/^about$/', App\Controllers\AboutController::class, 'show'],
    ['/^contacts$/', App\Controllers\ContactsController::class, 'show'],
    ['/^categories\/(\d+)\/edit$/',
        App\Controllers\CategoryController::class,
        'edit'
    ],
    ['/^art\/(\d+)\/edit$/', App\Controllers\ArtController::class, 'edit'],
    ['/^adminpanel$/', App\Controllers\UserController::class, 'admin'],
    ['/^api\/users\/login$/', App\Controllers\UserAPIController::class, 'login'],
    ['/^api\/users\/logout$/', App\Controllers\UserAPIController::class, 'logout'],
    ['/^api\/users\/registration$/',
        App\Controllers\UserAPIController::class,
        'registration'
    ],
    ['/^api\/art\/delete$/', App\Controllers\ArtAPIController::class, 'delete'],
    ['/^api\/art\/create$/', App\Controllers\ArtAPIController::class, 'create'],
    ['/^api\/art\/edit$/', App\Controllers\ArtAPIController::class, 'edit'],
    ['/^api\/art\/main/', App\Controllers\ArtAPIController::class, 'main'],
    ['/^api\/categories\/create$/',
        App\Controllers\CategoryAPIController::class,
        'create'
    ],
    ['/^api\/categories\/edit$/',
        App\Controllers\CategoryAPIController::class,
        'edit'
    ],
    ['/^api\/categories\/delete$/',
        App\Controllers\CategoryAPIController::class,
        'delete'
    ],
];
