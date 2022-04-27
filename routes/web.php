<?php

Route::group(config('translation.route_group_config') + ['namespace' => 'JoeDixon\\Translation\\Http\\Controllers'], function ($router) {
    $router->get('/', 'LanguageController@index')
        ->name('languages.index');

    $router->get('/create', 'LanguageController@create')
        ->name('languages.create');

    $router->post('/', 'LanguageController@store')
        ->name('languages.store');

    $router->get('/{language}/translations', 'LanguageTranslationController@index')
        ->name('languages.translations.index');

    $router->post('/{language}', 'LanguageTranslationController@update')
        ->name('languages.translations.update');

    $router->get('/{language}/translations/create', 'LanguageTranslationController@create')
        ->name('languages.translations.create');

    $router->post('/{language}/translations', 'LanguageTranslationController@store')
        ->name('languages.translations.store');
});
