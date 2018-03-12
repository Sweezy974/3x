<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PhotoType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('pathname')
        ->add('imageFile', VichImageType::class, array('required' => true,'label'=>false,'attr' => array('class' => 'col s12 m10 l10 offset-m1 offset-l1 center')))
        ->add('save', SubmitType::class, array('label' => 'envoyer','attr' => array('class' => '')));
    }/**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreetimeAdvisorBundle\Entity\Photo'
        ));
    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'freetimeadvisorbundle_photo';
    }


}
