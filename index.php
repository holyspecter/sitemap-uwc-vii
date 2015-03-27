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
    ->register(new \Silex\Provider\SessionServiceProvider())
;

\Hospect\Dependencies::configure($app);

$app->match('/', 'sitemap.controller:indexAction');

$app['debug'] = true; // todo remove

$app->run();
