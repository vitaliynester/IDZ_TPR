<?php

namespace App\Controller\Admin;

use App\Entity\WorkObject;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkObjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkObject::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Название объекта'),
        ];
    }
}
