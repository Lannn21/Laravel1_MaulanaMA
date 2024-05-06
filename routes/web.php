<?php

// use App\Http\Controllers\CobaController;

use App\Http\Controllers\CobaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'Home']);
Route::get('/product/{id}-{name}', [HomeController::class, 'Product']);

Route::get('/test', [CobaController::class, 'Index']);

Route::get('/contact', [ContactController::class, 'View']);
Route::post('/contact', [ContactController::class, 'ActionContact']);
Route::get('/contact/list', [ContactController::class, 'ContactList']);

Route::view('/cart', 'cart');
Route::view('/product', 'product');
Route::view('/login', 'login');
// Route::view('/contact', 'contact');



Route::post('/delete-contact', function(Request $request) {
    // Retrieve the email of the contact to be deleted from the request
    $email = $request->input('email');

    // Implement your logic here to delete the contact from the cookies
    // For example, you can use Laravel's Cookie facade

    // Return a success response
    return response()->json(['message' => 'Contact deleted successfully']);
});

Route::post('/clear-cookies', 'CookieController@clearCookies')->name('clear.cookies');