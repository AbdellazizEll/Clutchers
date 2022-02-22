<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class,[
                'mapped' => false
            ])
            ->add('prix')
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('qte')
            ->add('cat' , EntityType::class,['class' => Categories::class , 'choice_label' => 'nomC', 'expanded'=> false , 'multiple' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
