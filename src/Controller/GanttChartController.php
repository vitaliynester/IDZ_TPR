<?php

namespace App\Controller;

use App\Repository\WorkTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GanttChartController extends AbstractController
{
    /**
     * @Route("/chart", name="gantt_chart")
     */
    public function index(WorkTaskRepository $workTaskRepository): Response
    {
        $data = [];
        $workTasks = $workTaskRepository->findBy([], ['priority' => 'DESC']);
        $data['type'] = 0;

        foreach ($workTasks as $task) {
            $taskId = $task->getId();
            $data[$taskId]['title'] = $task->getTitle();
            $data[$taskId]['priority'] = $task->getPriority();
            $data[$taskId]['start_date'] = $task->getStartDate();
            $data[$taskId]['end_date'] = $task->getEndDate();
            $data[$taskId]['team'] = $task->getWorkTeam() ? $task->getWorkTeam()->getId() : -1;
            $data[$taskId]['color'] = $task->getStatus() == 1 ? '32CD32' : ($task->getStatus() == 2 ? 'FFFF00' : '8B0000');
        }

        return $this->render('gantt_chart/index.html.twig', [
            'controller_name' => 'Диаграммы расписаний',
            'data' => $data,
        ]);
    }

    /**
     * @Route("/chart/tasks", name="gantt_chart_tasks")
     */
    public function chartTasks(WorkTaskRepository $workTaskRepository): Response
    {
        $data = [];
        $workTasks = $workTaskRepository->findBy([], ['priority' => 'DESC']);
        $data['type'] = 1;

        foreach ($workTasks as $task) {
            $taskId = $task->getId();
            $data[$taskId]['title'] = $task->getTitle();
            $data[$taskId]['priority'] = $task->getPriority();
            $data[$taskId]['start_date'] = $task->getStartDate();
            $data[$taskId]['end_date'] = $task->getEndDate();
            $data[$taskId]['team'] = $task->getWorkTeam() ? $task->getWorkTeam()->getId() : -1;
            $data[$taskId]['color'] = $task->getStatus() == 1 ? '32CD32' : ($task->getStatus() == 2 ? 'FFFF00' : '8B0000');
        }

        return $this->render('gantt_chart/index.html.twig', [
            'controller_name' => 'Диаграммы по задачам',
            'data' => $data,
        ]);
    }

    /**
     * @Route("/chart/team", name="gantt_chart_team")
     */
    public function chartTeams(WorkTaskRepository $workTaskRepository): Response
    {
        $data = [];
        $data['type'] = 2;
        $workTasks = $workTaskRepository->findBy([], ['priority' => 'DESC']);

        foreach ($workTasks as $task) {
            if ($task->getWorkTeam() != null) {
                $taskId = $task->getId();
                $data[$taskId]['title'] = 'Бригада ' . $task->getWorkTeam()->getId();
                $data[$taskId]['priority'] = $task->getPriority();
                $data[$taskId]['start_date'] = $task->getStartDate();
                $data[$taskId]['end_date'] = $task->getEndDate();
                $data[$taskId]['team'] = $task->getWorkTeam();
                $data[$taskId]['task'] = $task->getTitle();
                $data[$taskId]['color'] = $task->getStatus() == 1 ? '32CD32' : ($task->getStatus() == 2 ? 'FFFF00' : '8B0000');
            }
        }

        return $this->render('gantt_chart/index.html.twig', [
            'controller_name' => 'Диаграммы по бригадам',
            'data' => $data,
        ]);
    }

    /**
     * @Route("/chart/team/{id}", name="gantt_chart_per_team")
     */
    public function chartTeam(int $id, WorkTaskRepository $workTaskRepository): Response
    {
        $data = [];
        $data['type'] = 1;
        $workTasks = $workTaskRepository->findBy(['workTeam' => $id], ['priority' => 'DESC']);

        foreach ($workTasks as $task) {
            $taskId = $task->getId();
            $data[$taskId]['title'] = $task->getTitle();
            $data[$taskId]['priority'] = $task->getPriority();
            $data[$taskId]['start_date'] = $task->getStartDate();
            $data[$taskId]['end_date'] = $task->getEndDate();
            $data[$taskId]['team'] = $task->getWorkTeam() ? $task->getWorkTeam()->getId() : -1;
            $data[$taskId]['color'] = $task->getStatus() == 1 ? '32CD32' : ($task->getStatus() == 2 ? 'FFFF00' : '8B0000');
        }

        return $this->render('gantt_chart/index.html.twig', [
            'controller_name' => "Диаграмма бригады №$id",
            'data' => $data,
        ]);
    }
}
