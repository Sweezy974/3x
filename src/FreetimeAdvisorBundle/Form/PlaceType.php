<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlaceType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name')
        ->add('location')
        ->add('description')
        ->add('city', EntityType::class, array(
          'mapped'=>true,
          'class' => 'FreetimeAdvisorBundle:City',
          'choice_label' => 'name',
        ))
        ->add('category', EntityType::class, array(
          'mapped'=>true,
          'class' => 'FreetimeAdvisorBundle:Category',
          'choice_label' => 'name',
        ))
        ->add('user')
        ->add('save', SubmitType::class, array('label' => 'envoyer','attr' => array('class' => '')));
    }/**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreetimeAdvisorBundle\Entity\Place'
        ));
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'freetimeadvisorbundle_place';
    }


}
