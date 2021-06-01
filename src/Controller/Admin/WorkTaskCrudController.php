<?php

namespace App\Controller\Admin;

use App\Entity\WorkTask;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkTask::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('workObject', 'Объект над которым работаем')->setRequired(true),
            TextField::new('title', 'Название задачи')->setRequired(true),
            TextEditorField::new('description', 'Описание задачи'),
            DateTimeField::new('start_date', 'Дата начала задачи')->setRequired(true)->setFormat('yyyy-mm-dd HH:mm')->renderAsChoice(),
            DateTimeField::new('end_date', 'Дата окончания задачи')->setRequired(true)->setFormat('yyyy-mm-dd HH:mm')->renderAsChoice(),
            IntegerField::new('priority','Приоритет задачи')->setRequired(true),
            AssociationField::new('workTeam', 'Выполняющая бригада'),
            ChoiceField::new('status', 'Статус выполнения')->setChoices(['Выполнена' => 1, 'В работе' => 2, 'Нет исполнителя' => 3])->setRequired(true),
        ];
    }
}
