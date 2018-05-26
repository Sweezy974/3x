<?php

namespace FreetimeAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AdviceType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('title')
    ->add('comment')
    ->add('score', ChoiceType::class, array(
    'choices'  => array(
        '1/5' => 1,
        '2/5' => 2 ,
        '3/5' => 3 ,
        '4/5' => 4 ,
        '5/5' => 5 ,
    )))
    ->add('save', SubmitType::class, array('label' => 'envoyer','attr' => array('class' => '')));
  }/**
  * {@inheritdoc}
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'FreetimeAdvisorBundle\Entity\Advice'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'freetimeadvisorbundle_advice';
  }


}
