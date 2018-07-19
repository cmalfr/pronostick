<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('team1', TextType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'placeholder' => 'Equipe1',

              )
            ))
            ->add('score1', IntegerType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'placeholder' => '0',
              )
            ))
            ->add('team2', TextType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'placeholder' => 'Equipe2',
              )
            ))
            ->add('score2', IntegerType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'placeholder' => '0',
              )
            ))
            ->add('date', DateTimeType::class, array(
                'widget' => 'choice',
                'attr' => array(
                    'class' => 'form-control blue-bg'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
