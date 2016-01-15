<?php

$router->group(['prefix' => '/modules'], function ($router) {
    // Modules
    $router->group(['middleware' => ['permission:modules::manage-modules']], function () {
        get('modules', ['as' => 'backend::modules.modules.index', 'uses' => 'ModulesController@index']);
        get('modules/{module}', ['as' => 'backend::modules.modules.show', 'uses' => 'ModulesController@show']);

        post('modules/{module}/disable', ['as' => 'backend::modules.modules.disable', 'uses' => 'ModulesController@disable']);
        post('modules/{module}/enable', ['as' => 'backend::modules.modules.enable', 'uses' => 'ModulesController@enable']);
    });

});
