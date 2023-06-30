<?php

namespace App\Controller\Admin;

use App\Entity\NftFlow;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NftFlowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NftFlow::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
