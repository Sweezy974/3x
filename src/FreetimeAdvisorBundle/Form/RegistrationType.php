<?php

namespace FreetimeAdvisorBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FreetimeAdvisorBundle\Entity\Category;
use FreetimeAdvisorBundle\Entity\City;

class RegistrationType extends AbstractType

{
  public function buildForm(FormBuilderInterface $builder, array $options)

  {
    $builder
    ->add('birthDate', BirthdayType::class, array('attr' => array('class' => 'date'),'label'=>false,'required' => true,'widget' => 'single_text','html5' => true))
    ->add('city', EntityType::class, array(
      'mapped'=>true,
      'class' => 'FreetimeAdvisorBundle:City',
      'choice_label' => 'name',
    ))
    ->add('description', TextareaType::class,array('required' => false,'attr' => array('placeholder'=>'décrivez-vous. max:300 caractère','maxlength' => 300)))
    ->add('imageFile', VichImageType::class, array('required' => true,'label'=>false,'attr' => array('class' => 'col s12 m10 l10 offset-m1 offset-l1 ')))
    ->add('save', SubmitType::class, array('label' => 'envoyer','attr' => array('class' => '')))
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
