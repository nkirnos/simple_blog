<?php

return [
    Route::get('/', '\\Controllers\\PostController::list'),
    Route::get('/posts', '\\Controllers\\PostController::list'),
    Route::post('/posts', '\\Controllers\\PostController::store'),
    Route::get('/posts/new', '\\Controllers\\PostController::new'),
    Route::get('/post/delete', '\\Controllers\\PostController::delete'),
    Route::get('/post/edit', '\\Controllers\\PostController::edit'),
    Route::get('/post', '\\Controllers\\PostController::view'),
    
];
