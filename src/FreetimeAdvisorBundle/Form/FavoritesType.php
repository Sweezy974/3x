<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FavoritesType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('userId', EntityType::class, array(
      // looks for choices from this entity
      'class' => 'FreetimeAdvisorBundle:User',
      'mapped'=>true,
      'choice_label' => 'id',
      // 'multiple' => 'true',
    ))
    ->add('placeId', EntityType::class, array(
      // looks for choices from this entity
      'class' => 'FreetimeAdvisorBundle:Place',
      'mapped'=>true,
      'choice_label' => 'id',
      // 'multiple' => 'true',
    ));
  }/**
  * {@inheritdoc}
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'FreetimeAdvisorBundle\Entity\Favorites'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'freetimeadvisorbundle_favorites';
  }


}
