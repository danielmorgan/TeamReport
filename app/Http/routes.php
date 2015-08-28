<?php

Route::group(['prefix' => 'api/v1'], function() {
    Route::get('projects', 'ProjectsController@index');
    Route::get('projects/{project}', 'ProjectsController@show');
    Route::get('projects/{project}/tasklists', 'TasklistsController@index');
    Route::get('projects/{project}/tasklists/{tasklist}', 'TasklistsController@show');
});

Route::get('generate', 'ReportsController@generate');

Route::get('/', ['as' => 'home', function() {
    return view('spa');
}]);

Route::any('{undefinedRoute}', function () {
    return Redirect::to('/');
})->where('undefinedRoute', '([A-z\d-\/_.]+)?');
