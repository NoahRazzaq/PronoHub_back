<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bet:read:history'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['bet:read:history'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: LeaderBoard::class, inversedBy: 'users')]
    private Collection $leaderBoards;

    #[ORM\ManyToMany(targetEntity: Bet::class, inversedBy: 'users')]
    private Collection $bet;

    #[ORM\ManyToMany(targetEntity: League::class, inversedBy: 'users')]
    private Collection $league;

    #[ORM\Column(length: 255)]
    #[Groups(['game:read:id'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['game:read:id'])]
    private ?string $lastname = null;

    #[ORM\OneToMany(mappedBy: 'idUserCreator', targetEntity: League::class)]
    private Collection $leagues;

    // #[ORM\Column(length: 255 )]
    // private ?string $username = null;

    public function __construct()
    {
        $this->leaderBoards = new ArrayCollection();
        $this->bet = new ArrayCollection();
        $this->league = new ArrayCollection();
        $this->leagues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, LeaderBoard>
     */
    public function getLeaderBoards(): Collection
    {
        return $this->leaderBoards;
    }

    public function addLeaderBoard(LeaderBoard $leaderBoard): static
    {
        if (!$this->leaderBoards->contains($leaderBoard)) {
            $this->leaderBoards->add($leaderBoard);
        }

        return $this;
    }

    public function removeLeaderBoard(LeaderBoard $leaderBoard): static
    {
        $this->leaderBoards->removeElement($leaderBoard);

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBet(): Collection
    {
        return $this->bet;
    }

    public function addBet(Bet $bet): static
    {
        if (!$this->bet->contains($bet)) {
            $this->bet->add($bet);
        }

        return $this;
    }

    public function removeBet(Bet $bet): static
    {
        $this->bet->removeElement($bet);

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeague(): Collection
    {
        return $this->league;
    }

    public function addLeague(League $league): static
    {
        if (!$this->league->contains($league)) {
            $this->league->add($league);
        }

        return $this;
    }

    public function removeLeague(League $league): static
    {
        $this->league->removeElement($league);

        return $this;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    // public function getUsername(): ?string
    // {
    //     return $this->username;
    // }

    // public function setUsername(string $username): static
    // {
    //     $this->username = $username;

    //     return $this;
    // }
}
