<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('nom', TextType::class,array( 'label' => 'nom ','attr' => array( 'placeholder' => 'Nom')))
                ->add('email', TextType::class, array('label' => 'Email','attr' => array( 'placeholder' => 'Email')))
                ->add('sujet', TextType::class, array('label' => 'Sujet','attr' => array( 'placeholder' => 'Sujet')))
                ->add('Content', TextType::class, array('label' => 'Content','attr' => array( 'placeholder' => 'Contenu')));
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
