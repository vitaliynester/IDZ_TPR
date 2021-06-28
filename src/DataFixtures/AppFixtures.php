<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\EmployeeSkills;
use App\Entity\Skill;
use App\Entity\TaskSkills;
use App\Entity\WorkObject;
use App\Entity\WorkTask;
use App\Entity\WorkTeam;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Создаем сотрудников
        $employeeList = [];
        for ($i = 1; $i <= 100; $i++) {
            $employee = new Employee();
            $employee->setLastName('Сотрудник');
            $employee->setFirstName("$i");
            $employee->setPosition("Должность $i");
            $manager->persist($employee);
            $employeeList[] = $employee;
        }

        // Создаем навыки
        $skillList = [];
        for ($i = 1; $i <= 10; $i++) {
            $skill = new Skill();
            $skill->setName("Навыки $i");
            $manager->persist($skill);
            $skillList[] = $skill;
        }

        // Создаем навыки сотрудников
        for ($i = 1; $i <= count($employeeList); $i++) {
            $countSkills = rand(2, 5);
            $skills = [];
            while (count($skills) != $countSkills) {
                $skills[] = rand(0, count($skillList) - 1);
                $skills = array_unique($skills);
            }

            foreach ($skills as $skillIdx) {
                $employeeSkill = new EmployeeSkills();
                $employeeSkill->setEmployee($employeeList[$i - 1]);
                $employeeSkill->setSkill($skillList[$skillIdx]);
                $employeeSkill->setSkillLevel(rand(0, 10));
                $manager->persist($employeeSkill);
            }
        }

        // Создаем объект над которым работаем
        $workObject = new WorkObject();
        $workObject->setName("Объект 1");
        $manager->persist($workObject);

        $dateList = [];
        $startDate = '2021-06-01';
        $endDate = '2021-07-31';

        while (strtotime($startDate) <= strtotime($endDate)) {
            $startDate = date("Y-m-d", strtotime("+1 day", strtotime($startDate)));
            $dateList[] = DateTime::createFromFormat("Y-m-d", $startDate);
        }

        // Создаем список задач над которыми работаем
        $taskList = [];
        for ($i = 1; $i <= 20; $i++) {
            $task = new WorkTask();
            $task->setWorkObject($workObject);
            $task->setTitle("Задача $i");

            $startIdx = rand(0, count($dateList) - 1);
            $endIdx = $startIdx + rand(0, max(count($dateList) - 1 - $startIdx, 1));

            $task->setStartDate($dateList[$startIdx]);
            $task->setEndDate($dateList[$endIdx]);

            $task->setPriority(rand(1, 10));
            $task->setStatus(3);

            $manager->persist($task);
            $taskList[] = $task;
        }

        // Создаем список необходимых навыков для задачи
        foreach ($taskList as $task) {
            $countSkills = rand(1, count($skillList) - 1);
            $skills = [];
            while (count($skills) != $countSkills) {
                $skills[] = rand(0, count($skillList) - 1);
                $skills = array_unique($skills);
            }

            foreach ($skills as $skillIdx) {
                $taskSkill = new TaskSkills();
                $taskSkill->setSkillLevel(rand(1, 10));
                $taskSkill->setSkill($skillList[$skillIdx]);
                $taskSkill->setWorkTask($task);

                $manager->persist($taskSkill);
            }
        }

        // Создаем бригады
        $globalCountEmployee = 0;
        $currentCountEmployee = 0;
        for ($i = 1; $i <= 15 && $globalCountEmployee <= count($employeeList); $i++) {
            $workTeam = new WorkTeam();
            $employeeInTeam = rand(2, 5);

            $globalCountEmployee += $employeeInTeam;
            for (; ($currentCountEmployee < $globalCountEmployee) && $currentCountEmployee < count($employeeList); $currentCountEmployee++) {
                $workTeam->addWorker($employeeList[$currentCountEmployee]);
            }
            $manager->persist($workTeam);

        }

        $manager->flush();
    }
}
