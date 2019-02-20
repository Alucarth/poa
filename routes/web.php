<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('roles','RolController',['names'=>['index'=>'roles']]);
Route::resource('programacion_medio_plazo','MediumTermProgramingController',
                ['names'=>[
                    'index'=>'programacion_medio_plazo',
                    'create'=>'medio_plazo_nuevo'
                          ]
                ]);
Route::resource('users','UserController',[
    'names' => [
        'index' => 'users',
        //'store' => 'users.store',
        // etc...
    ]
]);