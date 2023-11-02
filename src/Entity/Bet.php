<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: BetRepository::class)]
class Bet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'bets')]
    #[ApiResource]
    private Collection $userId;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $teamId = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    private ?Matches $matchId = null;

    #[ORM\ManyToOne(inversedBy: 'bets')]
    private ?Ligue $ligueId = null;

    #[ORM\Column]
    private ?bool $isDraw = null;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTeamId(): ?Team
    {
        return $this->teamId;
    }

    public function setTeamId(?Team $teamId): static
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getMatchId(): ?Matches
    {
        return $this->matchId;
    }

    public function setMatchId(?Matches $matchId): static
    {
        $this->matchId = $matchId;

        return $this;
    }

    public function getLigueId(): ?Ligue
    {
        return $this->ligueId;
    }

    public function setLigueId(?Ligue $ligueId): static
    {
        $this->ligueId = $ligueId;

        return $this;
    }

    public function isIsDraw(): ?bool
    {
        return $this->isDraw;
    }

    public function setIsDraw(bool $isDraw): static
    {
        $this->isDraw = $isDraw;

        return $this;
    }
}
