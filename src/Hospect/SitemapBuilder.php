<?php

namespace Hospect;

use Hospect\Model\SitemapConfig;

class SitemapBuilder
{
    /** @var LinksCollector  */
    private $linksCollector;

    private $xmlBuilder;

    public function __construct(LinksCollector $linksCollector, $xmlBuilder = null) // @todo remove default
    {
        $this->linksCollector = $linksCollector;
        $this->xmlBuilder     = $xmlBuilder;
    }


    public function createSitemap(SitemapConfig $sitemapConfig)
    {
        $this->linksCollector->setMaxNestingLevel($sitemapConfig->getMaxNestingLevel());

        $links = $this->linksCollector->getAllUniqueLinks($sitemapConfig->getUrl(), 1);

        var_dump($links); die;

        return $this->xmlBuilder->buildXml($links, $sitemapConfig);
    }
} 
