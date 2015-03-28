<?php

namespace Hospect\Form;

use Hospect\Model\SitemapConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SitemapConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', 'url', [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Url(),
                ],
            ])
            ->add('changeFreq', 'choice', [
                'choices' => SitemapConfig::getChangeFreqs(),
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('maxNestingLevel', 'number', [
                'data' => 1,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThan(0),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SitemapConfig::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sitemap';
    }
}
