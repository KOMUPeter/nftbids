<?php

namespace App\Controller\Admin;

use App\Admin\Field\AdresseField;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('plainPassword'),// password harshed from event App\EventListener
            ChoiceField::new('roles') // create choice list fields for the roles
                ->setChoices([
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_BUYER' => 'ROLE_BUYER',
                    'ROLE_SELLER' => 'ROLE_SELLER',
                ])
                ->setFormTypeOptions([ // define wheather the fields are checkboxs or radio
                    'multiple' => true,
                    'expanded' => false,
                ])
            ,
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('gender'),
            DateField::new('dateOfBirth'),
            AdresseField::new('lives'), // created a formType and admin adresse field to enable handle the field AdresseField in association entity
        ];
    }
}