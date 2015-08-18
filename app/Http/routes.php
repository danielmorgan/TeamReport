<?php

Route::get('/', function () {
    return view('projects');
});

Route::get('generate', function() {
    Artisan::callSilent('reports:generate');
});
