<?php

namespace App\Controller\Admin;

use App\Entity\EmployeeSkills;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeSkillsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EmployeeSkills::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('employee', 'Сотрудник')->setRequired(true),
            AssociationField::new('skill', 'Навык')->setRequired(true),
            IntegerField::new('skillLevel', 'Уровень владения')->setRequired(true),
        ];
    }
}
