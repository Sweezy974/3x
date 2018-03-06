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

class RegistrationType extends AbstractType

{
  public function buildForm(FormBuilderInterface $builder, array $options)

  {
    $builder
    ->add('description', TextareaType::class,array('required' => false,'attr' => array('maxlength' => 300)))
    ->add('age', BirthdayType::class, array('attr' => array('class' => 'date'),'label'=>false,'required' => true,'widget' => 'single_text','html5' => true))
    ->add('city', ChoiceType::class, array('required' => true,
    'choices'  => array(
      'Yes' => NULL,
      'No' => false,)))
    ->add('imageFile', VichImageType::class, array('required' => true,'label'=>false,'attr' => array('class' => 'col s12 m10 l10 offset-m1 offset-l1 center')))
    ->add('favorite_categories', EntityType::class, array(
      'mapped'=>false,
        // looks for choices from this entity
        'class' => 'FreetimeAdvisorBundle:Category',
        'choice_value' => function (Category $category = null) {
            return $category ? $category->getId() : '';
        },
        // uses the User.username property as the visible option string
        'choice_label' => 'name',

        // used to render a select box, check boxes or radios
        'multiple' => true,

        // 'expanded' => true,
    ))
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
