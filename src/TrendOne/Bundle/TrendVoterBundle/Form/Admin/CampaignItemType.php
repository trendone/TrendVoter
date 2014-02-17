<?php

namespace TrendOne\Bundle\TrendVoterBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignItemType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('imageResource', 'file')
            ->add('description')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TrendOne\Bundle\TrendVoterBundle\Entity\CampaignItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'trendone_bundle_trendvoterbundle_admin_campaignitem';
    }
}
