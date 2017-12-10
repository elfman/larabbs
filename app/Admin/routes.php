<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

//    $router->get('/users/index', "UserController@index");
//    $router->get('/topics/index', 'TopicController@index');
//    $router->get('/replies/index', 'ReplyController@index');
    $router->resources([
        'users' => UserController::class,
        'topics' => TopicController::class,
        'replies' => ReplyController::class,
        'links' => LinkController::class,
    ]);
//    $router->resource('topics', TopicController::class);
});
