<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
#[ApiResource]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $score1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $score2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banner = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMatch = null;

    #[ORM\OneToMany(mappedBy: 'matchId', targetEntity: Bet::class)]
    private Collection $bets;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    private ?Team $teamId1 = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    private ?Team $teamId2 = null;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->teamId1 = new ArrayCollection();
        $this->teamId2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(?int $score1): static
    {
        $this->score1 = $score1;

        return $this;
    }

    public function getScore2(): ?int
    {
        return $this->score2;
    }

    public function setScore2(?int $score2): static
    {
        $this->score2 = $score2;

        return $this;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): static
    {
        $this->banner = $banner;

        return $this;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    public function setDateMatch(?\DateTimeInterface $dateMatch): static
    {
        $this->dateMatch = $dateMatch;

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
            $bet->setMatchId($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getMatchId() === $this) {
                $bet->setMatchId(null);
            }
        }

        return $this;
    }

    public function getTeamId1(): ?Team
    {
        return $this->teamId1;
    }

    public function setTeamId1(?Team $teamId1): static
    {
        $this->teamId1 = $teamId1;

        return $this;
    }

    public function getTeamId2(): ?Team
    {
        return $this->teamId2;
    }

    public function setTeamId2(?Team $teamId2): static
    {
        $this->teamId2 = $teamId2;

        return $this;
    }

}