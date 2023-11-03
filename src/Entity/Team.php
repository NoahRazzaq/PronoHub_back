<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'teamId1', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Bet::class)]
    private Collection $bets;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->bets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->games;
    }

    public function addMatch(Game $match): static
    {
        if (!$this->games->contains($match)) {
            $this->games->add($match);
            $match->setTeamId1($this);
        }

        return $this;
    }

    public function removeMatch(Game $match): static
    {
        if ($this->games->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getTeamId1() === $this) {
                $match->setTeamId1(null);
            }
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
            $bet->setTeam($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getTeam() === $this) {
                $bet->setTeam(null);
            }
        }

        return $this;
    }
}
