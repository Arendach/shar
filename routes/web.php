<?php


/**
 * Front Routs
 */
Route::middleware('cache.response')->group(function () {
    Route::get('/', 'IndexController@section_main');
    Route::get('product/{id}', 'ProductController@show')->name('product');
    Route::get('category/{slug}', 'CategoryController@show')->name('category');
});

Route::get('/search/{query}', 'SearchController@index')->middleware('global');
Route::redirect('/search', '/');


Route::get('/f/{id}', function ($id) {
    return Redirect::to(uri('admin/feedback/' . $id));
});


/**
 * Admin Routs
 */
Route::post('/admin/login', 'Admin\UserController@action_login');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'IndexController@section_main');
    Route::get('/feedback/{id}', 'FeedbackController@section_view');

    Route::get('/{controller}', function ($controller) {
        $classname = 'App\\Http\\Controllers\\Admin\\' . ucfirst($controller) . 'Controller';
        if (class_exists($classname)) {
            $obj = new $classname();
            return $obj->get_handle(get());
        }
    })->where(['controller' => '[a-z]+']);

    Route::post('/{controller}', function ($controller) {
        $classname = 'App\\Http\\Controllers\\Admin\\' . ucfirst($controller) . 'Controller';
        if (class_exists($classname)) {
            $obj = new $classname();
            return $obj->post_handle($_POST);
        }
    })->where(['controller' => '[a-z]+']);
});


/**
 * Front Universal Routs
 */
Route::post('/{controller}', function ($controller) {
    $classname = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';
    if (class_exists($classname)) {
        $obj = new $classname();
        return $obj->post_handle($_POST);
    }
})->where(['controller' => '[a-z]+'])->middleware('global');
