<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    Route::get('/{any}', 'AdminController@index')->where('any', '.*');
});
