<?php

//auth
Route::group(['prefix' => '/auth', 'namespace' => "Auth", 'middleware' => ['csrf']], function () {
    Route::get('login',                     'LoginController@showLoginForm')->name('login');
    Route::post('login',                    'LoginController@login');
    Route::get('logout',                    'LoginController@logout')->name('logout');
    Route::post('logout',                   'LoginController@logout')->name('logout');
});

//
Route::group(['prefix' => '/', 'middleware' => ['auth', 'permission']], function () {
    Route::post('/menu/tree',               'MenuController@tree');
    Route::resource('/menu',                'MenuController');
    Route::get('/role/{id}/permission',     'RoleController@permissionEdit');
    Route::post('/role/{id}/permission',    'RoleController@permissionStore');
    Route::resource('/role',                'RoleController');
    Route::resource('/user',                'UserController');
    Route::resource('/permission',          'PermissionController');
    Route::resource('/info',                'InfoController');
    Route::resource('/log',                 'LogController');
    Route::resource('/loginLog',            'LoginLogController');

    Route::resource('/',                    'HomeController');
});