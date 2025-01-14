
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;

// API Routes

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Example route

// Add your other routes here