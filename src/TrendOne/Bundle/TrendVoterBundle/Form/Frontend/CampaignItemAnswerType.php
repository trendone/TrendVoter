<?php

namespace TrendOne\Bundle\TrendVoterBundle\Form\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignItemAnswerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answerX', 'choice', array('choices' => range(0, 6), 'empty_value' => ''))
            ->add('answerY', 'choice', array('choices' => range(0, 6), 'empty_value' => ''))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TrendOne\Bundle\TrendVoterBundle\Entity\CampaignItemAnswer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'trendone_bundle_trendvoterbundle_frontend_campaignitemanswer';
    }
}
