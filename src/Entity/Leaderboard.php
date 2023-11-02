<?php

namespace App\Entity;

use App\Repository\LeaderboardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: LeaderboardRepository::class)]
#[ApiResource]
class Leaderboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'leaderboards')]
    private Collection $userId;

    #[ORM\Column(nullable: true)]
    private ?int $points = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbWin = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbLose = null;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getNbWin(): ?int
    {
        return $this->nbWin;
    }

    public function setNbWin(?int $nbWin): static
    {
        $this->nbWin = $nbWin;

        return $this;
    }

    public function getNbLose(): ?int
    {
        return $this->nbLose;
    }

    public function setNbLose(?int $nbLose): static
    {
        $this->nbLose = $nbLose;

        return $this;
    }
}
