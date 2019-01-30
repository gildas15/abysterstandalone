<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PasserelleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('msisdn')->add('countryCode')->add('state',  ChoiceType::class, ['choices' => ['Selectionner votre status'=>'Selectionner votre status', 'Active'=>'Active', 'Inactive' =>'Inactive']])->add('regularExpression')->add('name')->add('typeTransaction',  ChoiceType::class , ['choices' => ['Selectionner le type de transaction'=>'Selectionner le type de transaction', 'TRANSFERT_MOBILE_MONEY'=>'TRANSFERT_MOBILE_MONEY']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Passerelle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_passerelle';
    }


}
