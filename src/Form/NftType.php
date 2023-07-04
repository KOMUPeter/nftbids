<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Nft;
use App\Form\ImageType;
use App\Form\NftFlowType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nftName')
            ->add('nftCreationDate')
            ->add('initialPrice')
            ->add('isAvailable')
            ->add('quantity')
            ->add('actualPrice')
            ->add('nftFlow', NftFlowType::class)
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'required' => true,
            ])
            ->add('nftImage', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'prototype_name' => '__nftImage__',
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nft::class,
        ]);
    }
}