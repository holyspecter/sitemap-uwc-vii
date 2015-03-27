<?php

namespace Hospect;

class LinksCollector
{
    private $webCrawler;

    private $maxNestingLevel = 2;

    /** @var array  */
    private $links = [];

    /**
     * @param WebCrawler $webCrawler
     */
    public function __construct(WebCrawler $webCrawler)
    {
        $this->webCrawler = $webCrawler;
    }

    /**
     * @param int $maxNestingLevel
     */
    public function setMaxNestingLevel($maxNestingLevel)
    {
        $this->maxNestingLevel = (int) $maxNestingLevel;
    }

    /**
     * @param string $url
     * @param int    $currentLevel
     * @return array
     */
    public function getAllUniqueLinks($url, $currentLevel)
    {
        $links = $this->webCrawler->getLinks($url);
        foreach ($links as $link) {
            if (! in_array($link, $this->links)) {
                $this->links[] = $link;

                if ($currentLevel < $this->maxNestingLevel) {
                    $this->getAllUniqueLinks($link, $currentLevel + 1);
                }
            }
        }

        return $this->links;
    }
} 
