<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlaceType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class, array('attr' => array( 'class' => 'text-uppercase' )))
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
        ->add('description')
        ->add('location')
        // ->add('date', DateType::class, array('years' => range(1940,2016),))
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
