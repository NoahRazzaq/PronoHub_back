<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToMany(targetEntity: Leaderboard::class, mappedBy: 'userId')]
    private Collection $leaderboards;

    #[ORM\ManyToMany(targetEntity: Bet::class, mappedBy: 'userId')]
    private Collection $bets;

    #[ORM\ManyToMany(targetEntity: Ligue::class, inversedBy: 'users')]
    private Collection $leagueId;

    public function __construct()
    {
        $this->leaderboards = new ArrayCollection();
        $this->bets = new ArrayCollection();
        $this->leagueId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Leaderboard>
     */
    public function getLeaderboards(): Collection
    {
        return $this->leaderboards;
    }

    public function addLeaderboard(Leaderboard $leaderboard): static
    {
        if (!$this->leaderboards->contains($leaderboard)) {
            $this->leaderboards->add($leaderboard);
            $leaderboard->addUserId($this);
        }

        return $this;
    }

    public function removeLeaderboard(Leaderboard $leaderboard): static
    {
        if ($this->leaderboards->removeElement($leaderboard)) {
            $leaderboard->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): static
    {
        if (!$this->bets->contains($bet)) {
            $this->bets->add($bet);
            $bet->addUserId($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            $bet->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ligue>
     */
    public function getLeagueId(): Collection
    {
        return $this->leagueId;
    }

    public function addLeagueId(Ligue $leagueId): static
    {
        if (!$this->leagueId->contains($leagueId)) {
            $this->leagueId->add($leagueId);
        }

        return $this;
    }

    public function removeLeagueId(Ligue $leagueId): static
    {
        $this->leagueId->removeElement($leagueId);

        return $this;
    }
}
