<?php


/**
 * Front Routs
 */
Route::get('/', 'IndexController@section_main');

Route::get('/f/{id}', function ($id) {
    return Redirect::to(uri('admin/feedback/' . $id));
});

Route::post('/admin/login', 'Admin\UserController@action_login');

Route::get('/norm', 'NormController@index');

Route::get('/scripts.js', 'FrontController@scripts');

/**
 * Admin Routs
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'IndexController@section_main');
    Route::get('/feedback/{id}', 'FeedbackController@section_view');

    Route::get('/{controller}', function ($controller){
        $classname = 'App\\Http\\Controllers\\Admin\\' . ucfirst($controller) . 'Controller';
        if (class_exists($classname)){
            $obj = new $classname();
            return $obj->get_handle(get());
        }
    })->where(['controller' => '[a-z]+']);

    Route::post('/{controller}', function ($controller){
        $classname = 'App\\Http\\Controllers\\Admin\\' . ucfirst($controller) . 'Controller';
        if (class_exists($classname)){
            $obj = new $classname();
            return $obj->post_handle($_POST);
        }
    })->where(['controller' => '[a-z]+']);
});

Route::get('/search/{query}', 'SearchController@index')->middleware('global');


/**
 * Front Universal Routs
 */

Route::get('/{controller}', function ($controller){

    $classname = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';
    if (class_exists($classname)){
        $obj = new $classname();
        return $obj->get_handle(get());
    }
})->where(['controller' => '[a-z]+'])
    ->middleware('global');

Route::post('/{controller}', function ($controller){
    $classname = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';
    if (class_exists($classname)){
        $obj = new $classname();
        return $obj->post_handle($_POST);
    }
})->where(['controller' => '[a-z]+'])->middleware('global');
