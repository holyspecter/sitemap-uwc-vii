<?php

namespace Hospect;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator;

class LinksCollector
{
    /** @var WebCrawler  */
    private $webCrawler;

    /** @var Validator  */
    private $validator;

    /** @var int  */
    private $maxNestingLevel = 2;

    /** @var  string */
    private $host = '';

    /** @var array  */
    private $links = [];

    /**
     * @param WebCrawler $webCrawler
     * @param Validator  $validator
     */
    public function __construct(WebCrawler $webCrawler, Validator $validator)
    {
        $this->webCrawler = $webCrawler;
        $this->validator = $validator;
    }

    /**
     * @param int $maxNestingLevel
     */
    public function setMaxNestingLevel($maxNestingLevel)
    {
        $this->maxNestingLevel = (int) $maxNestingLevel;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $url
     * @param int    $currentLevel
     * @return array
     */
    public function getAllUniqueLinks($url, $currentLevel)
    {
        if (! $this->isValidUrl($url)) {
            return $this->links;
        }

        $links = $this->webCrawler->getLinks($url, $this->host);

        foreach ($links as $link) {
            if ($this->shouldProcessLink($link)) {
                $this->links[] = $link;

                if ($currentLevel < $this->maxNestingLevel) {
                    $this->getAllUniqueLinks($link, $currentLevel + 1);
                }
            }
        }

        return $this->links;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isValidUrl($url)
    {
        $errors = $this->validator->validateValue($url, new Assert\Url());

        return count($errors) === 0;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function shouldProcessLink($url)
    {
        $parsedUrl = parse_url($url);
        $linkHost = isset($parsedUrl['host']) ? $parsedUrl['host'] : null;

        return (! $linkHost || $this->host === $linkHost) && ! in_array($url, $this->links);
    }
} 
