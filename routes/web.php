<?php

use Illuminate\Support\Facades\Route;

Route::any('{path}', function() {
    return response()->json([
        'message' => __('Route not found.')
    ], 404);
})->where('path', '.*');
