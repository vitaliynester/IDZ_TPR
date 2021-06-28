<?php

namespace App\Controller\Admin;

use App\Entity\WorkTeam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class WorkTeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkTeam::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('workers', 'Количество работников'),
            AssociationField::new('workTasks', 'Задача')->hideOnIndex(),
        ];
    }
}
