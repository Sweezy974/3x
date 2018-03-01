<?php

namespace FreetimeAdvisorBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType

{
  public function buildForm(FormBuilderInterface $builder, array $options)

  {
    $builder
    ->add('description')
    ->add('age', DateType::class, array('years' => range(1940,2018)))
    ->add('imageFile', VichImageType::class, array('label' => ' ', 'required' => true))
    ->add('city')

    ;
  }

  public function getParent()

  {
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  public function getBlockPrefix()

  {
    return 'app_user_registration';
  }


}
