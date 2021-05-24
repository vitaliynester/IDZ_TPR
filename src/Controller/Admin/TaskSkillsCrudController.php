<?php

namespace App\Controller\Admin;

use App\Entity\TaskSkills;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class TaskSkillsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TaskSkills::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('workTask', 'Задача над которой работаем')->setRequired(true),
            AssociationField::new('skill', 'Необходимый навык')->setRequired(true),
            BooleanField::new('isRequired', 'Необходим ли данный навык')->setRequired(true),
        ];
    }
}
