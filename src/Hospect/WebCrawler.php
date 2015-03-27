<?php

namespace Hospect;

use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

class WebCrawler
{
    /** @var Client  */
    private $httpClient;

    /**
     * @param Client  $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getLinks($url)
    {
        $links = [];

        $response = $this->httpClient->get($url)->send();
        if ($response->isSuccessful()) {
            $domCrawler = new Crawler($response->getBody(true));
            $domCrawler->filter('a')->each(function (Crawler $crawler) use (&$links) {
                $links[] = $crawler->attr('href');
            });
        }

        return $links;
    }
} 
