<?php

namespace Hospect\Controller;

use Guzzle\Http\Exception\RequestException;
use Silex\Application;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SitemapController
{
    /** @var FormFactory  */
    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var Form $form */
        $form = $this->app['form.factory']->createBuilder('sitemap')->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                try {
                    $sitemap = $this->app['sitemap.builder']->createSitemap($form->getData());

                    $response = new Response($sitemap);
                    $response->headers->set('Content-Type', 'text/xml');

                    return $response;
                } catch (RequestException $e) {
                    $message = sprintf("Error occurred while parsing `%s`", $e->getRequest()->getUrl());
                    $this->app['session']->getFlashBag()->add('error', $message);
                }
            }
        }

        return new Response($this->app['twig']->render('index.html.twig', [
            'form' => $form->createView(),
        ]));
    }
} 
