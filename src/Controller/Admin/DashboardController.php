<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Entity\EmployeeSkills;
use App\Entity\Skill;
use App\Entity\SkillCategory;
use App\Entity\TaskSkills;
use App\Entity\WorkObject;
use App\Entity\WorkTask;
use App\Entity\WorkTeam;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // После перехода на страницу /admin отображаем CRUD для сущности работника
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(EmployeeCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Распределение задач');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Сотрудники', 'fas fa-list', Employee::class);
        yield MenuItem::linkToCrud('Навыки сотрудника', 'fas fa-list', EmployeeSkills::class);
        yield MenuItem::linkToCrud('Навыки', 'fas fa-list', Skill::class);
        yield MenuItem::linkToCrud('Категория навыков', 'fas fa-list', SkillCategory::class);
        yield MenuItem::linkToCrud('Навыки необходимые для задачи', 'fas fa-list', TaskSkills::class);
        yield MenuItem::linkToCrud('Объект над которым работаем', 'fas fa-list', WorkObject::class);
        yield MenuItem::linkToCrud('Задачи', 'fas fa-list', WorkTask::class);
        yield MenuItem::linkToCrud('Команды', 'fas fa-list', WorkTeam::class);
    }
}
