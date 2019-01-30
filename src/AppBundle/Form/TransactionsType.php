<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('emailSender')->add('customerName')->add('emailRecipient')->add('msisdnSender')->add('countryCode')->add('msisdnRecipient')->add('dateTransfert')->add('description')->add('orderId')->add('redirectUrl')->add('idSms')->add('fees')->add('dateReceptionSms')->add('amountTtc')->add('typeOperation')->add('currency')->add('state')->add('totalAmountReceived')->add('deltaAmount');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Transactions'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_transactions';
    }


}
