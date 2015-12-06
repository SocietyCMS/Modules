<?php

$router->group(['prefix' => '/modules'], function () {
    get('modules', ['as' => 'backend::modules.modules.index', 'uses' => 'ModulesController@index']);
    get('modules/{module}', ['as' => 'backend::modules.modules.show', 'uses' => 'ModulesController@show']);
});
