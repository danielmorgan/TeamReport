<?php

Route::get('/', function () {
    Artisan::call('reports:generate');
});
