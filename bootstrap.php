<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app
    ->register(new \Silex\Provider\FormServiceProvider())
    ->register(new \Silex\Provider\ServiceControllerServiceProvider())
    ->register(new Silex\Provider\TwigServiceProvider(), [
        'twig.path' => __DIR__.'/views',
    ])
    ->register(new \Silex\Provider\LocaleServiceProvider())
    ->register(new \Silex\Provider\TranslationServiceProvider())
;

$app['form.extensions'] = $app->extend('form.extensions', function ($extensions) use ($app) {
    $extensions[] = new \Hospect\Form\SitemapExtension();

    return $extensions;
});


// todo not working
$app['sitemap.controller'] = function () use ($app) {
    return new \Hospect\Controller\SitemapController($app['form.factory'], $app['twig']);
};

$app->match('/', 'sitemap.controller:indexAction');

$app['debug'] = true; // todo remove

$app->run();
