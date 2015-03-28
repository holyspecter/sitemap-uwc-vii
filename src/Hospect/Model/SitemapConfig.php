<?php

namespace Hospect\Model;

/**
 * @todo: more fields?
 */
class SitemapConfig
{
    /** @var  string */
    private $url;

    /** @var  string */
    private $changeFreq;

    /** @var  int */
    private $maxNestingLevel;

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
     * @return int
     */
    public function getMaxNestingLevel()
    {
        return $this->maxNestingLevel;
    }

    /**
     * @param int $maxNestingLevel
     * @return $this
     */
    public function setMaxNestingLevel($maxNestingLevel)
    {
        $this->maxNestingLevel = $maxNestingLevel;

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
