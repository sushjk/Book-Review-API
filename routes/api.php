<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



Route::middleware(['auth:sanctum'])->group(function () {

    // Routes accessible by both
    // Route::get('/profile', function () {
    //     return "hello profile";
    // });

    // Admin-only routes
    Route::middleware('ability:admin')->group(function () {
        // Route::get('/admin/dashboard', function () {
        //     return response()->json(['message' => 'Welcome Admin']);
        // });


        Route::post('/admin/books', [BookController::class, 'store']);
        Route::put('/admin/books/{book}', [BookController::class, 'update']);
        Route::delete('/admin/books/{book}', [BookController::class, 'destroy']);


    });

    // User-only routes
    Route::middleware('ability:user')->group(function () {
        // Route::get('/user/dashboard', function () {
        //     return response()->json(['message' => 'Welcome User']);
        // });

        //book review system
        Route::post('/books/{bookId}/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{id}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);


    });

});



//  Public book listing route
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

