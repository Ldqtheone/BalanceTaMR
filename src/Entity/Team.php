<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture_url;

    /**
     * @ORM\ManyToMany(targetEntity=TeamProject::class, mappedBy="team")
     */
    private $teamProjects;

    public function __construct()
    {
        $this->teamProjects = new ArrayCollection();
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

    public function getPictureUrl(): ?string
    {
        return $this->picture_url;
    }

    public function setPictureUrl(string $picture_url): self
    {
        $this->picture_url = $picture_url;

        return $this;
    }

    /**
     * @return Collection|TeamProject[]
     */
    public function getTeamProjects(): Collection
    {
        return $this->teamProjects;
    }

    public function addTeamProject(TeamProject $teamProject): self
    {
        if (!$this->teamProjects->contains($teamProject)) {
            $this->teamProjects[] = $teamProject;
            $teamProject->addTeam($this);
        }

        return $this;
    }

    public function removeTeamProject(TeamProject $teamProject): self
    {
        if ($this->teamProjects->contains($teamProject)) {
            $this->teamProjects->removeElement($teamProject);
            $teamProject->removeTeam($this);
        }

        return $this;
    }
}
