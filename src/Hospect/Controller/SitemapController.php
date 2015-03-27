<?php

namespace Hospect\Controller;

use Hospect\SitemapBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class SitemapController
{
    /** @var FormFactory  */
    private $formFactory;

    /** @var \Twig_Environment  */
    private $renderer;

    /** @var SitemapBuilder  */
    private $sitemapBuilder;

    /**
     * @param FormFactory       $formFactory
     * @param \Twig_Environment $renderer
     * @param SitemapBuilder    $sitemapBuilder
     */
    public function __construct(FormFactory $formFactory, \Twig_Environment $renderer, SitemapBuilder $sitemapBuilder)
    {
        $this->formFactory = $formFactory;
        $this->renderer = $renderer;
        $this->sitemapBuilder = $sitemapBuilder;
    }

    public function indexAction(Request $request)
    {
        $form = $this->formFactory->createBuilder('sitemap')->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->sitemapBuilder->createSitemap($form->getData());
            }
        }

        return $this->renderer->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
} 
