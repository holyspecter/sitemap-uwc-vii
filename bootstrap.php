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

// @todo move service definitions to dedicated file

$app['http_client'] = function () {
    return new \Guzzle\Http\Client();
};

$app['web_crawler'] = function () use ($app) {
    return new \Hospect\WebCrawler($app['http_client']);
};

$app['links_collector'] = function () use ($app) {
    return new \Hospect\LinksCollector($app['web_crawler']);
};

$app['xml_builder'] = function () use ($app) {
    // @todo implement
};

$app['sitemap.builder'] = function () use ($app) {
    return new \Hospect\SitemapBuilder($app['links_collector']); // @todo inject xmlBuilder
};

$app['sitemap.controller'] = function () use ($app) {
    return new \Hospect\Controller\SitemapController($app['form.factory'], $app['twig'], $app['sitemap.builder']);
};

$app->match('/', 'sitemap.controller:indexAction');

$app['debug'] = true; // todo remove

$app->run();
