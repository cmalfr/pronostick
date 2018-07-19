<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\RolesType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('username', TextType::class)
          ->add('plainPassword', RepeatedType::class, array(
              'type' => PasswordType::class,
              'first_options'  => array('label' => 'Mot de passe'),
              'second_options' => array('label' => 'Confirmation'),
            ))
            ->add('roles', RolesType::class,array(
                'label' => 'Roles'
            ))          ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
            'roles' => "ROLE_USER"
        ]);
    }
}
