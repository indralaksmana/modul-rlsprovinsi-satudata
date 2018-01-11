<?php

Route::group(['prefix' => 'rlsprovinsi'], function() {
    Route::get('/', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getIndex');
    Route::get('/list', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getList');
    Route::get('/detail/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@detailRlsProvinsi');
    Route::get('/create', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@createRlsProvinsi');
    Route::post('/create', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@createRlsProvinsiSave');
    Route::get('/update/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@updateRlsProvinsi');
    Route::post('/update/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getIndex');
    Route::post('/delete/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getIndex');
    Route::post('/activate/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getIndex');
    Route::post('/unactivate/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getIndex');
    Route::get('/getKota/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getKota');
    Route::get('/export/{id}', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@export');
    Route::get('/getColumns', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getColumns');
    Route::get('/getProvinsi', 'Satudata\Rlsprovinsi\Http\Controllers\RlsProvinsiController@getProvinsi');
});
