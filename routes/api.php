<?php

use Illuminate\Support\Facades\Route;
use Spatie\TagsField\Http\Controllers\TagsFieldController;

Route::get('/', TagsFieldController::class);
Route::post('/update/{resource}', 'Spatie\TagsField\Http\Controllers\TagsFieldController@update');
