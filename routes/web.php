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

Route::get('adm3', function () {
    return view('layouts.adm3');
});



Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'ExecutionController@index')->name('home');
    Route::resource('roles','RolController',['names'=>['index'=>'roles']]);

    Route::resource('action_medium_term','ActionMediumTermController');

    Route::get('action_short_term_year/{year_id}','ActionShortTermController@action_short_term_year')->name('action_short_term_year');

    Route::resource('action_short_term','ActionShortTermController');
    
    Route::get('ast_operations/{action_short_term_id}','OperationController@ast_operations')->name('ast_operations');

    Route::resource('operations','OperationController');

    Route::get ('operation_tasks/{operation_id}','TaskController@operation_tasks')->name('operation_tasks');

    Route::resource('tasks','TaskController');

    Route::get('execution_year/{year_month}','ExecutionController@execution_year')->name('exection_year');

    Route::resource('executions','ExecutionController');
  
    // //reportes
    // Route::get('amp_report_excel','MediumTermProgramingController@report_excel');
    // Route::get('acp_report_excel','ShortTermProgramingController@report_excel');
}); 
