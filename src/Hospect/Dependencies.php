<?php

namespace Hospect;

use Guzzle\Http\Client;
use Hospect\Controller\SitemapController;
use Hospect\Form\SitemapExtension;
use Hospect\LinksCollector;
use Hospect\SitemapBuilder;
use Hospect\WebCrawler;
use Silex\Application;

class Dependencies
{
    /**
     * @param Application $app
     */
    public static function configure(Application $app)
    {
        $app['form.extensions'] = $app->extend('form.extensions', function ($extensions) use ($app) {
            $extensions[] = new SitemapExtension();

            return $extensions;
        });

        $app['http_client'] = function () {
            return new Client();
        };

        $app['web_crawler'] = function () use ($app) {
            return new WebCrawler($app['http_client']);
        };

        $app['links_collector'] = function () use ($app) {
            return new LinksCollector($app['web_crawler']);
        };

        $app['xml_builder'] = function () use ($app) {
            // @todo implement
        };

        $app['sitemap.builder'] = function () use ($app) {
            return new SitemapBuilder($app['links_collector']); // @todo inject xmlBuilder
        };

        $app['sitemap.controller'] = function () use ($app) {
            return new SitemapController($app['form.factory'], $app['twig'], $app['sitemap.builder']);
        };
    }
}
