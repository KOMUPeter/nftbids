<?php

namespace App\Controller\Admin;

use App\Entity\Nft;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nft::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nftName'),
            IntegerField::new('initialPrice'),
            IntegerField::new('actualPrice'),
            IntegerField::new('quantity'),
            DateField::new('nftCreationDate')->hideOnForm(),
            BooleanField::new('isAvailable'),
            AssociationField::new('categories', 'Catégorie(s)')
                ->setFormTypeOptions(['by_reference' => false]),
        ];
    }
}
