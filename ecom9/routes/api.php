<?php

use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('App\Http\Controllers\API')->group(function () {
    // Register Router for React App
    Route::post('register-user', 'APIController@registerUser');
    // Login user Router for React App
    Route::post('login-user', 'APIController@loginUser');

    // Update Profile Details / Profile API
    Route::post('update-user', 'APIController@updateUser');

    // CMS pages Route
    $cmsUrls = CmsPage::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($cmsUrls as $url) {
        Route::get($url, 'APIController@cmsPage');
    }

    //Categories menu API
    Route::get('menu', 'APIController@menu');
});
