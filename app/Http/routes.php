<?php

Route::get('/', function () {
    return view('projects');
});

Route::get('projects', 'ProjectsController@index');
Route::get('projects/{project}', 'ProjectsController@show');
Route::get('projects/{project}/tasklists', 'TasklistsController@index');
Route::get('projects/{project}/tasklists/{tasklist}', 'TasklistsController@show');

Route::get('generate', function() {
    Artisan::callSilent('reports:generate');
});
