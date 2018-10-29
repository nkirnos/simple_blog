<?php

return [
    Route::get('/', '\\Controllers\\HomeController::index'),
    Route::get('/posts', '\\Controllers\\PostController::list'),
    Route::post('/posts', '\\Controllers\\PostController::store'),
    Route::get('/posts/new', '\\Controllers\\PostController::new'),
    
];
