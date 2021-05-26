<?php

namespace App\Entity;

use App\Repository\WorkTaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkTaskRepository::class)
 */
class WorkTask
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\OneToMany(targetEntity=TaskSkills::class, mappedBy="workTask", orphanRemoval=true)
     */
    private $taskSkills;

    /**
     * @ORM\ManyToOne(targetEntity=WorkObject::class, inversedBy="workTask")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workObject;

    /**
     * @ORM\OneToOne(targetEntity=WorkTeam::class, inversedBy="workTask", cascade={"persist", "remove"})
     */
    private $workTeam;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    public function __construct()
    {
        $this->taskSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Collection|TaskSkills[]
     */
    public function getTaskSkills(): Collection
    {
        return $this->taskSkills;
    }

    public function addTaskSkill(TaskSkills $taskSkill): self
    {
        if (!$this->taskSkills->contains($taskSkill)) {
            $this->taskSkills[] = $taskSkill;
            $taskSkill->setWorkTask($this);
        }

        return $this;
    }

    public function removeTaskSkill(TaskSkills $taskSkill): self
    {
        if ($this->taskSkills->removeElement($taskSkill)) {
            // set the owning side to null (unless already changed)
            if ($taskSkill->getWorkTask() === $this) {
                $taskSkill->setWorkTask(null);
            }
        }

        return $this;
    }

    public function getWorkObject(): ?WorkObject
    {
        return $this->workObject;
    }

    public function setWorkObject(?WorkObject $workObject): self
    {
        $this->workObject = $workObject;

        return $this;
    }

    public function getWorkTeam(): ?WorkTeam
    {
        return $this->workTeam;
    }

    public function setWorkTeam(?WorkTeam $workTeam): self
    {
        $this->workTeam = $workTeam;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
