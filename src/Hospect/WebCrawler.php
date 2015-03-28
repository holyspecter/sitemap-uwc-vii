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
     * @param string $host
     * @return array
     */
    public function getLinks($url, $host)
    {
        $links = [];
        $response = null;

        $response = $this
            ->httpClient
            ->get($this->prepareUrl($url, $host))
            ->send()
        ;

        if ($response && $response->isSuccessful()) {
            $domCrawler = new Crawler($response->getBody(true));
            $domCrawler->filter('a')->each(function (Crawler $crawler) use (&$links, $host) {
                $links[] = $this->prepareUrl($crawler->attr('href'), $host);
            });
        }

        return $links;
    }

    /**
     * @param string $url
     * @param string $host
     * @return string
     */
    private function prepareUrl($url, $host)
    {
        $parsedUrl = parse_url($url);
        if (! isset($parsedUrl['host'])) {
            return '/' === $url[0] ? 'http://'.$host.$url : 'http://'.$host.'/'.$url;
        }

        return $url;
    }
} 
