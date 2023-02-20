<?php

Route::group(['prefix' => 'form-builder'], function () {
    Route::get('forms/get-action-template/{key}', 'FormsController@getActionTemplate');
    Route::resource('forms', 'FormsController');
    Route::resource('forms.submissions', 'FormSubmissionsController', [
        'parameters' => ['submissions' => 'formSubmission'],
        'only' => ['index', 'destroy', 'show'],
    ]);

    Route::get('settings', 'FormsController@settings');
    Route::post('settings', 'FormsController@saveSettings');
});

Route::group(['prefix' => 'forms'], function () {
    Route::get('{form}/embed', 'FormsController@embed');
    Route::post('public/{form}', 'FormsController@publicSubmit');
    Route::post('{form}', 'FormsController@submit');
});

Route::group(['prefix' => 'autoresponder'], function () {
    Route::get('authorize-weber', 'AutoResponderController@authorizeAweberApp')->name('aweber.authorize');
});
