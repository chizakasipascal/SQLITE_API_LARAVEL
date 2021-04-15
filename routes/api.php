<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Produt;


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

Route::get('/getproducts', function () {
    return Produt::all();
});

Route::post('/postproducts', function () {
    return Produt::create([
        'name'=>'Products one',
        'slug'=>'Products - one',
        'description'=>'This is produt one',
        'price'=>'99,99'
    ]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
