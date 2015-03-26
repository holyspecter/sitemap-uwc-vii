<?php

namespace Hospect\Model;

/**
 * @todo: more fields?
 * @todo validation
 */
class Sitemap
{
    /** @var  string */
    private $url;

    /** @var  string */
    private $changeFreq;

    /**
     * @return string
     */
    public function getChangeFreq()
    {
        return $this->changeFreq;
    }

    /**
     * @param string $changeFreq
     * @return $this
     */
    public function setChangeFreq($changeFreq)
    {
        $this->changeFreq = $changeFreq;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array
     */
    public static function getChangeFreqs()
    {
        return [
            'always' => 'Always',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'never' => 'Never',
        ];
    }
}
