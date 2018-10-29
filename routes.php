<?php

return [
    Route::get('/', '\\Controllers\\HomeController::index'),
    Route::get('/posts', '\\Controllers\\PostController::list'),
    
];
