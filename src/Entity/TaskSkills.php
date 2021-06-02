<?php

namespace App\Entity;

use App\Repository\TaskSkillsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskSkillsRepository::class)
 */
class TaskSkills
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $skillLevel;

    /**
     * @ORM\ManyToOne(targetEntity=WorkTask::class, inversedBy="taskSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workTask;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkillLevel(): ?int
    {
        return $this->skillLevel;
    }

    public function setSkillLevel(int $skillLevel): self
    {
        $this->skillLevel = $skillLevel;

        return $this;
    }

    public function getIsRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function getWorkTask(): ?WorkTask
    {
        return $this->workTask;
    }

    public function setWorkTask(?WorkTask $workTask): self
    {
        $this->workTask = $workTask;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function __toString()
    {
        return "$this->id | $this->skill | $this->skillLevel";
    }
}
