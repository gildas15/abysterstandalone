<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ABAccountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $initial = "";
            $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXY123456789";
            srand((double)microtime()*1000000);
            for($i=0; $i<30; $i++) {
            $initial .= $chaine[rand()%strlen($chaine)];
            }
        $chaineConsumerSecret =md5($initial);
        $builder->add('email')->add('cosumerSecret', textType::class , array('data' => $chaineConsumerSecret,  'attr' => ['readonly' => true]))->add('status', ChoiceType::class , ['choices' => ['Selectionner votre status'=>'Selectionner votre status', 'Active'=>'Active', 'Inactive' =>'Inactive']] )->add('address')->add('phoneNumber')->add('socialReason');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ABAccount'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_abaccount';
    }


}
