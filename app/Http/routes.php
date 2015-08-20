<?php

Route::get('/', function () {
    return view('spa');
});

Route::get('demo', function () {
    return view('projects');
});

Route::group(['prefix' => 'api/v1'], function() {
	Route::get('projects', 'ProjectsController@index');
	Route::get('projects/{project}', 'ProjectsController@show');
	Route::get('projects/{project}/tasklists', 'TasklistsController@index');
	Route::get('projects/{project}/tasklists/{tasklist}', 'TasklistsController@show');
});

Route::get('generate', function() {
    Artisan::callSilent('reports:generate');
});
