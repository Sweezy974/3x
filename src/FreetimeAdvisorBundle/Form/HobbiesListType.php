<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FreetimeAdvisorBundle\Entity\Category;

class HobbiesListType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('first', EntityType::class, array(
            // looks for choices from this entity
            'class' => 'FreetimeAdvisorBundle:Category',
            'mapped'=>true,
            'choice_label' => 'name',
            // 'multiple' => 'true',
        ))
        ->add('second', EntityType::class, array(
            // looks for choices from this entity
            'class' => 'FreetimeAdvisorBundle:Category',
            'mapped'=>true,
            'choice_label' => 'name',
            // 'multiple' => 'true',
        ))
        ->add('third', EntityType::class, array(
            // looks for choices from this entity
            'class' => 'FreetimeAdvisorBundle:Category',
            'mapped'=>true,
            'choice_label' => 'name',
            // 'multiple' => 'true',
        ))
        ->add('save', SubmitType::class, array('label' => 'envoyer','attr' => array('class' => '')));
    }/**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreetimeAdvisorBundle\Entity\HobbiesList'
        ));
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'freetimeadvisorbundle_hobbies';
    }


}
