<?php

namespace App\Entity;

use App\Repository\WorkObjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkObjectRepository::class)
 */
class WorkObject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=WorkTask::class, mappedBy="workObject", orphanRemoval=true)
     */
    private $workTasks;

    public function __construct()
    {
        $this->workTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $workTask->setWorkObject($this);
        }

        return $this;
    }

    public function removeWorkTask(WorkTask $workTask): self
    {
        if ($this->workTasks->removeElement($workTask)) {
            // set the owning side to null (unless already changed)
            if ($workTask->getWorkObject() === $this) {
                $workTask->setWorkObject(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
