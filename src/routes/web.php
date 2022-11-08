<?php

Route::group(['prefix' => 'bi', 'as' => 'bi'], function () {
    Route::group(['namespace' => 'Xguard\BusinessIntelligence\Http\Controllers',], function () {

        Route::group(['middleware' => ['web']], function () {

            // Setting sessions variables and checking if user is still logged in
            Route::get('/set-sessions', 'AppController@setBusinessIntelligenceAppSessionVariables');

            Route::group(['middleware' => ['bi_role_check']], function () {

                // We'll let vue router handle 404 (it will redirect to dashboard)
                Route::fallback('AppController@getIndex');

                // All view routes are handled by vue router
                Route::get('/', 'AppController@getIndex');

                // Business Intelligence App Data
                Route::get('/get-role-and-employee-id', 'AppController@getRoleAndEmployeeId');
                Route::get('/get-footer-info', 'AppController@getFooterInfo');

                // Employees
                Route::post('/create-or-update-employees', 'EmployeeController@createOrUpdateEmployees')->name('.createOrUpdateEmployees');
                Route::delete('/delete-employee/{id}', 'EmployeeController@deleteEmployee')->name('.deleteEmployee');
                Route::get('/get-employees', 'EmployeeController@getAllEmployees')->name('.getEmployees');
                Route::get('/get-employee-profile', 'EmployeeController@getEmployeeProfile')->name('.getEmployeeProfile');

                //ERP Data
                Route::get('/get-all-users', 'ErpController@getAllUsers')->name('.getAllUsers');
                Route::get('/get-some-users/{searchTerm}', 'ErpController@getSomeUsers')->name('.getSomeUsers');
                Route::get('/get-all-contracts', 'ErpController@getAllActiveContracts')->name('.');
                Route::get('/get-some-contracts/{searchTerm}', 'ErpController@getSomeActiveContracts')->name('.getSomeActiveContracts');
            });
        });
    });
});
