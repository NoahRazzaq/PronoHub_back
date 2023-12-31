<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\TeamController;
use App\Repository\TeamRepository;
use App\State\TeamStateProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['team:read'], 'swagger_definition_name' => 'Read'],
    operations: [
        new Get(
            name: 'teamID', 
        uriTemplate: '/teams/{id}', 
        controller: TeamController::class
    ),
        new GetCollection(),
        new Post(),
        new Put(
            denormalizationContext: ['groups' => ['team:write']],
        ),
        new Patch(),
        new Delete(),

    
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['type' => 'exact'])]

class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['game:read:id'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['team:write','game:read:all','game:read:id'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['team:write','game:read:all','game:read:id'])]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'teamId1', targetEntity: Game::class)]
    #[Groups(['team:write', 'team:read'])]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Bet::class)]
    #[Groups(['team:write', 'team:read'])]
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
     * @return Collection<int, Games>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setTeamId1($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTeamId1() === $this) {
                $game->setTeamId1(null);
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
