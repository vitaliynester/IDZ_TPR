<?php

namespace App\Controller;

use App\Entity\WorkTask;
use App\Entity\WorkTeam;
use App\Repository\SkillRepository;
use App\Repository\WorkTaskRepository;
use App\Repository\WorkTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkTaskController extends AbstractController
{
    /**
     * @Route("/work/task_table", name="work_task")
     */
    public function index(WorkTaskRepository $workTaskRepository, SkillRepository $skillRepository): Response
    {
        $data = [];
        $workTasks = $workTaskRepository->findAll();

        foreach ($workTasks as $task) {
            $taskId = $task->getId();
            $data[$taskId]['title'] = $task->getTitle();
            $data[$taskId]['priority'] = $task->getPriority();
            $data[$taskId]['start_date'] = $task->getStartDate();
            $data[$taskId]['end_date'] = $task->getEndDate();

            if (count($task->getTaskSkills()) != 0) {
                foreach ($task->getTaskSkills() as $skill) {
                    $data[$taskId]['skills'][$skill->getSkill()->getId()] = [
                        'title' => $skill->getSkill()->getName(),
                        'level' => $skill->getSkillLevel(),
                    ];
                }
            }
            else {
                $data[$taskId]['skills'] = [];
            }

            if ($task->getWorkTeam() != null) {

                $data[$taskId]['team'] = $task->getWorkTeam()->getId();
                if (count($task->getTaskSkills()) == 0)
                    return $this->json($task->getId());
                foreach ($task->getTaskSkills() as $skill) {
                    $data[$taskId]['skills'][$skill->getSkill()->getId()] = [
                        'title' => $skill->getSkill()->getName(),
                        'level' => $skill->getSkillLevel(),
                    ];
                }

                foreach ($task->getWorkTeam()->getWorkTeamSkills() as $id => $level) {
                    $skillDesc = $skillRepository->find($id);
                    $data[$taskId]['teamSkills'][$id] = [
                        'title' => $skillDesc->getName(),
                        'level' => $level,
                    ];
                }
                if (count($task->getWorkTeam()->getWorkTeamSkills()) == 0)
                    return $this->json($task->getWorkTeam()->getId());

                $data[$taskId]['color'] = $this->getRowColor($data[$taskId]['skills'], $data[$taskId]['teamSkills']);
            }
            else {
                $data[$taskId]['team'] = '-';
                $data[$taskId]['teamSkills'] = [];
                $data[$taskId]['color'] = 'default';
            }
        }

        usort($data, array($this, 'tableDataCmp'));
        return $this->render('work_task/index.html.twig', [
            'controller_name' => 'WorkTaskController',
            'tasks' => $data,
        ]);
    }

    /**
     * @Route("/work/task_dist", name="work_task_dist")
     */
    public function distributeTasks(WorkTaskRepository $workTaskRepository, WorkTeamRepository $workTeamRepository): Response
    {
        $tasks = $workTaskRepository->findAllUncompleted();
        usort($tasks, array($this, 'task_cmp'));

        $workTeams = $workTeamRepository->findAll();

        $distTable = [];

        while (!empty($tasks) && !empty($workTeams)) {
            $task =  reset($tasks);
            $teamId = $this->findBestWorkTeam($task, $workTeams);
            $distTable[] = [
                'taskId' => $task->getId(),
                'teamId' => $teamId
            ];

            $tasks = array_splice($tasks, 1);
            if (($key = array_search($workTeamRepository->findOneBy(['id' => $teamId]), $workTeams, true)) !== false) {
                unset($workTeams[$key]);
            }
        }

        $tasks = $workTaskRepository->findAllUncompleted();
        foreach ($tasks as $task) {
            $task->setWorkTeam(null);
            $task->setStatus(3);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
        }

        foreach ($distTable as $dist) {
            $task = $workTaskRepository->findOneBy(['id' => $dist['taskId']]);
            $task->setWorkTeam($workTeamRepository->findOneBy(['id' => $dist['teamId']]));
            $task->setStatus(2);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('work_task');
    }

    private function task_cmp(WorkTask $task1, WorkTask $task2)
    {
        if ($task1->getPriority() == $task2->getPriority()) {
            if ($task1->getEndDate() == $task2->getEndDate()) {
                return 0;
            }
            else {
                return $task1->getEndDate() > $task2->getEndDate() ? 1 : -1;
            }
        }
        else {
            return $task1->getPriority() < $task2->getPriority() ? 1 : -1;
        }
    }

    private function tableDataCmp($task1, $task2)
    {
        if ($task1['priority'] == $task2['priority']) {
            if ($task1['end_date'] == $task2['end_date']) {
                return 0;
            }
            else {
                return $task1['end_date'] > $task2['end_date'] ? 1 : -1;
            }
        }
        else {
            return $task1['priority'] < $task2['priority'] ? 1 : -1;
        }
    }

    private function findBestWorkTeam(WorkTask $task, array $teams)
    {
        $metrics = [];

        foreach ($teams as $team) {
            $metrics[] = [
                'teamId' => $team->getId(),
                'sameSkillsCount' => $this->getSameSkillsCount($task, $team),
                'skillsDiff' => $this->getSkillsDiff($task, $team),
            ];
        }

        usort($metrics, array($this, 'metrics_cmp'));

        return $metrics[0]['teamId'];
    }

    private function getSameSkillsCount(WorkTask $task, WorkTeam $team) {
        $taskSkills = $task->getTaskSkills();
        $teamSkills = $team->getWorkTeamSkills();

        $sameSkillsCount = 0;
        foreach ($taskSkills as $id => $value) {
            if (array_key_exists($id, $teamSkills)) {
                $sameSkillsCount++;
            }
        }

        return $sameSkillsCount;
    }

    private function getSkillsDiff(WorkTask $task, WorkTeam $team) {
        $taskSkills = $task->getTaskSkills();
        $teamSkills = $team->getWorkTeamSkills();

        $skillsDiff = 0;

        foreach ($taskSkills as $taskSkill) {
            if (array_key_exists($taskSkill->getSkill()->getId(), $teamSkills)) {
                $skillsDiff += $teamSkills[$taskSkill->getSkill()->getId()] - $taskSkill->getSkillLevel();
            }
            else {
                $skillsDiff -= $taskSkill->getSkillLevel();
            }
        }

        return $skillsDiff;
    }

    private function metrics_cmp(array $metric1, array $metric2)
    {
        if ($metric1['sameSkillsCount'] == $metric2['sameSkillsCount']) {
           if ($metric1['skillsDiff'] == $metric2['skillsDiff']) {
               return 0;
           }
           else {
               return $metric1['skillsDiff'] < $metric2['skillsDiff'] ? 1 : -1;
           }
        }
        else {
            return $metric1['sameSkillsCount'] < $metric2['sameSkillsCount'] ? 1 : -1;
        }
    }


    private function getRowColor($taskSkills, $teamSkills) {
        $lessElemCount = 0;
        foreach ($taskSkills as $id => $value) {
            if (!array_key_exists($id, $teamSkills) || $teamSkills[$id]['level'] < $value['level']) {
                $lessElemCount++;
            }
        }

        if ($lessElemCount === 0)
            return 'success';
        elseif ($lessElemCount === count($taskSkills))
            return 'danger';
        else
            return 'warning';
    }


}
