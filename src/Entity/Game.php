<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Controller\GameController;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            name: 'gamesID', 
            uriTemplate: '/games/{id}', 
            controller: GameController::class,
            normalizationContext: ['groups' => ['game:read:id']],
            denormalizationContext: ['groups' => ['game:write:id']],
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['game:read:all']]
        ),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['game:read:all'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['game:read:all','game:read:id'])]
    private ?int $score1 = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['game:read:all','game:read:id'])]
    private ?int $score2 = null;

    #[ORM\Column(length: 255)]
    #[Groups(['game:read:all'])]
    private ?string $banner = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['game:read:all','game:read:id'])]
    private ?\DateTimeInterface $dateMatch = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[Groups(['game:read:all','game:read:id'])]
    private ?Team $teamId1 = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[Groups(['game:read:all','game:read:id'])]
    private ?Team $teamId2 = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Bet::class)]
    #[Groups(['game:read:all','game:read:id'])]
    private Collection $bets;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[Groups(['game:read:all'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?LeagueApi $leagueApi = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFinished = null;

    #[ORM\Column(nullable: true)]
    private ?int $round = null;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->isFinished = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore1(): ?int
    {
        return $this->score1;
    }

    public function setScore1(int $score1): static
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

    public function setBanner(string $banner): static
    {
        $this->banner = $banner;

        return $this;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    public function setDateMatch(\DateTimeInterface $dateMatch): static
    {
        $this->dateMatch = $dateMatch;

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
            $bet->setGame($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getGame() === $this) {
                $bet->setGame(null);
            }
        }

        return $this;
    }

    public function getcategory(): ?Category
    {
        return $this->category;
    }

    public function setcategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLeagueApi(): ?LeagueApi
    {
        return $this->leagueApi;
    }

    public function setLeagueApi(?LeagueApi $leagueApi): static
    {
        $this->leagueApi = $leagueApi;

        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(?bool $isFinished): static
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): static
    {
        $this->round = $round;

        return $this;
    }
    
}
