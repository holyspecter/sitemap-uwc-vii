<?php

namespace Hospect;

use Hospect\Model\SitemapConfig;

class SitemapBuilder
{
    /** @var LinksCollector  */
    private $linksCollector;

    /** @var \Twig_Environment  */
    private $renderer;

    /**
     * @param LinksCollector    $linksCollector
     * @param \Twig_Environment $renderer
     */
    public function __construct(LinksCollector $linksCollector, \Twig_Environment $renderer)
    {
        $this->linksCollector = $linksCollector;
        $this->renderer     = $renderer;
    }

    /**
     * @param SitemapConfig $sitemapConfig
     * @return string
     */
    public function createSitemap(SitemapConfig $sitemapConfig)
    {
        $this->linksCollector->setMaxNestingLevel($sitemapConfig->getMaxNestingLevel());
        $this->linksCollector->setHost(parse_url($sitemapConfig->getUrl())['host']);

        $links = $this->linksCollector->getAllUniqueLinks($sitemapConfig->getUrl(), 1);

//        var_dump($links); die;

        return $this->renderer->render('sitemap.xml.twig', [
            'urls' => $links,
            'sitemap' => $sitemapConfig,
        ]);
    }
} 
