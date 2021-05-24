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
     * @ORM\OneToOne(targetEntity=WorkTask::class, mappedBy="workTeam", cascade={"persist", "remove"})
     */
    private $workTask;

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

    public function getWorkTask(): ?WorkTask
    {
        return $this->workTask;
    }

    public function setWorkTask(?WorkTask $workTask): self
    {
        // unset the owning side of the relation if necessary
        if ($workTask === null && $this->workTask !== null) {
            $this->workTask->setWorkTeam(null);
        }

        // set the owning side of the relation if necessary
        if ($workTask !== null && $workTask->getWorkTeam() !== $this) {
            $workTask->setWorkTeam($this);
        }

        $this->workTask = $workTask;

        return $this;
    }

    public function __toString()
    {
        return "$this->id";
    }
}
