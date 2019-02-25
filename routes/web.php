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
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('roles','RolController',['names'=>['index'=>'roles']]);
    Route::resource('programacion_medio_plazo','MediumTermProgramingController',
                    ['names'=>[
                        'index'=>'programacion_medio_plazo',
                        'create'=>'medio_plazo_nuevo'
                            ]
                    ]);
    Route::resource('programacion_corto_plazo','ShortTermProgramingController',
                    ['names'=>[
                        'index'=>'programacion_corto_plazo',
                        // 'create'=>'corto_plazo_nuevo'
                            ]
                    ]);
    Route::get('corto_plazo_nuevo/{id}','ShortTermProgramingController@createPCP')->name('corto_plazo_nuevo');
    Route::resource('users','UserController',[
        'names' => [
            'index' => 'users',
            //'store' => 'users.store',
            // etc...
        ]
    ]);
    Route::resource('operaciones','OperacionController',
    ['names'=>[
        'index'=>'operaciones',
        'edit'=>'operaciones.edit'
            ]
    ]);
    Route::resource('eficacias','EfficacyController',
    ['names'=>[
        'index'=>'eficacias',
        'edit'=>'eficacias.edit'
            ]
    ]);
    Route::get('asignar_tarea/{operation_id}','OperacionController@asignar_tarea');
    Route::post('asignar_tarea','OperacionController@store_task');

    //reportes
    Route::get('amp_report_excel','MediumTermProgramingController@report_excel');
    Route::get('acp_report_excel','ShortTermProgramingController@report_excel');
}); 
