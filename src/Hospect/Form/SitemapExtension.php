<?php

namespace Hospect\Form;

use Symfony\Component\Form\AbstractExtension;

class SitemapExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypes()
    {
        return [
            new SitemapType(),
        ];
    }
} 
