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
    Route::resource('users','UserController',['names'=>['index'=>'users']]);

    Route::resource('action_medium_term','ActionMediumTermController',['names'=>['index'=>'action_medium_term']])
    ;
    Route::post('action_medium_term/delete','ActionMediumTermController@delete')->name('action_medium_term_delte');
    Route::get('last_amt','ActionMediumTermController@last_amt')->name('last_amt');

    Route::get('action_short_term_year/{year_id}','ActionShortTermController@action_short_term_year')->name('action_short_term_year');

    Route::resource('action_short_term','ActionShortTermController');
    Route::post('action_short_term/delete','ActionShortTermController@delete')->name('delete_action_short_term');

    Route::get('ast_operations/{action_short_term_id}','OperationController@ast_operations')->name('ast_operations');

    Route::resource('operations','OperationController');

    Route::get ('operation_tasks/{operation_id}','TaskController@operation_tasks')->name('operation_tasks');
    Route::post('operation/delete','OperationController@delete');
    Route::resource('tasks','TaskController');
    Route::post('task/delete','TaskController@delete');

    Route::get('execution_year/{year_month}','ExecutionController@execution_year')->name('exection_year'); //para tareas
    Route::get('execution_specific_task/{year_month}','ExecutionController@execution_specific_task')->name('execution_specific_task'); //para tareas especificas

    Route::resource('executions','ExecutionController');

    Route::get('execution_specific_task/{specific_task_id}/edit','ExecutionController@specific_task_edit')->name('specific_task_edit');
    Route::post('specific_task_store','ExecutionController@specific_task_store')->name('specific_task_store');
    Route::get('specific_task_show/{specific_task_id}','ExecutionController@specific_task_show')->name('specific_task_show');
    Route::get('get_programmatic_structures','ActionShortTermController@getProgrammaticStructures'); //structura programatica
    Route::get('get_programmatic_operations','OperationController@getProgrammaticOperations');//operaciones de la estructura XD
    // Route::get('specific_task/{task_id}/{programming_id}','SpecificTaskController@specific_task')->name('specific_task');
    Route::get('specific_task/{task_id}','SpecificTaskController@specific_task')->name('specific_task');
    Route::resource('specific_tasks','SpecificTaskController');
    Route::post('specific_tasks/delete','SpecificTaskController@delete');

    Route::get('execution_specific_tasks','ExecutionController@specific_tasks');//vista

    Route::resource('report', 'ReportController');
    Route::get('report_excel','ReportController@report_excel');
    Route::get('report_pdf','ReportController@report_pdf');
    Route::post('report_task','ReportController@report_task');
    Route::post('report_operation','ReportController@report_operation');
    Route::post('report_ast','ReportController@report_ast');
    Route::post('report_year','ReportController@report_year');
    Route::post('report_amt','ReportController@report_amt');

    Route::get('chart','ReportController@chart');
    Route::get('years_list','ReportController@years_list');
    Route::get('amt_year/{month}','ReportController@amt_year');
    Route::get('ast_year/{month}','ReportController@ast_year');

    Route::get('check_meta_ast/{year_id}','ActionShortTermController@check_meta');
    Route::get('check_meta_operation/{action_short_term_id}','OperationController@check_meta');
    Route::get('check_meta_task/{operation_id}','TaskController@check_meta');
    Route::get('check_meta_specific_task/{task_id}','SpecificTaskController@check_meta');


    Route::resource('programatic_structure','ProgramaticStructureController');
    Route::post('programatic_structure/delete','ProgramaticStructureController@delete')->name('delete_programatic_structure');
    Route::get('test','ReportController@test');

    Route::resource('configuration', 'SystemController');
    // //reportes
    // Route::get('amp_report_excel','MediumTermProgramingController@report_excel');
    // Route::get('acp_report_excel','ShortTermProgramingController@report_excel');
});
