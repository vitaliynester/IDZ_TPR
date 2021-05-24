<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Entity\EmployeeSkills;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('last_name', "Фамилия")->setRequired(true),
            TextField::new('first_name', "Имя")->setRequired(true),
            TextField::new('patronymic', "Отчество"),
            TextField::new('position', "Должность")->setRequired(true),
            AssociationField::new('workTeam', "Команда"),
            AssociationField::new('skills', 'Навыки работника'),
        ];
    }
}
