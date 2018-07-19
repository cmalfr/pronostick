<?php

namespace App\Form;

use App\Entity\Pronostic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class PronosticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pscore1', IntegerType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'value' => '0',
              )
            ))
            ->add('pscore2', IntegerType::class, array(
              'attr' => array(
                  'class' => 'form-control form-white',
                  'value' => '0',
              )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pronostic::class,
        ]);
    }
}
