<?php

namespace App\Entity;

use App\Repository\WorkTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkTeamRepository::class)
 */
class WorkTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="workTeam")
     */
    private $workers;

    /**
     * @ORM\OneToMany(targetEntity=WorkTask::class, mappedBy="workTeam")
     */
    private $workTasks;

    public function __construct()
    {
        $this->workers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    public function addWorker(Employee $worker): self
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
            $worker->setWorkTeam($this);
        }

        return $this;
    }

    public function removeWorker(Employee $worker): self
    {
        if ($this->workers->removeElement($worker)) {
            // set the owning side to null (unless already changed)
            if ($worker->getWorkTeam() === $this) {
                $worker->setWorkTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|WorkTask[]
     */
    public function getWorkTasks(): Collection
    {
        return $this->workTasks;
    }

    public function addWorkTask(WorkTask $workTask): self
    {
        if (!$this->workTasks->contains($workTask)) {
            $this->workTasks[] = $workTask;
            $workTask->setWorkTeam($this);
        }

        return $this;
    }

    public function removeWorkTask(WorkTask $workTask): self
    {
        if ($this->workTasks->removeElement($workTask)) {
            // set the owning side to null (unless already changed)
            if ($workTask->getWorkTeam() === $this) {
                $workTask->setWorkTeam(null);
            }
        }

        return $this;
    }

    public function getWorkTeamSkills(): array
    {
        $workers  = $this->getWorkers();
        $teamSkills = [];
        $sumWeights = [];
        foreach ($workers as $worker) {
            foreach ($worker->getSkills() as $skill) {
                $skillLevel = $skill->getSkillLevel();
                $skillId = $skill->getSkill()->getId();

                if (!array_key_exists($skillId, $teamSkills)) {
                    $teamSkills[$skillId] = 0;
                }

                switch ($skillLevel) {
                    case ($skillLevel < 3):
                        $skillWeight = 0.3;
                        break;
                    case ($skillLevel >= 3 && $skillLevel < 5):
                        $skillWeight = 0.5;
                        break;
                    case ($skillLevel >= 5 && $skillLevel < 7):
                        $skillWeight = 1;
                        break;
                    case ($skillLevel >= 7):
                        $skillWeight = 1.5;
                        break;
                    default:
                        $skillWeight = 1;
                        break;
                }
                $sumWeights[$skillId][] = $skillWeight;
                $teamSkills[$skillId] += $skill->getSkillLevel() * $skillWeight;
            }
        }
        foreach ($teamSkills as $key => $value) {
            $teamSkills[$key] /= array_sum($sumWeights[$key]);
        }

        return $teamSkills;
    }

    public function __toString()
    {
        return "$this->id";
    }
}
