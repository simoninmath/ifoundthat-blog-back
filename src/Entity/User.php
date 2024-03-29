<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource (
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:User:collection']]),
        new Post(normalizationContext: ['groups' => ['read:User:item']]),
        new Get(normalizationContext: ['groups' => ['read:User:item']]),
        new Put(normalizationContext: ['groups' => ['read:User:item']]),
        new Delete(normalizationContext: ['groups' => ['read:User:item']]),
        new Patch(normalizationContext: ['groups' => ['read:User:item']]),
    ]
)
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    #[Assert\Email(message: 'This email {{ value }}" is not a valid email address.')]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(min: 6, minMessage: 'Your password must be 6 characters or less.')]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private ?bool $enabled = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: true)]
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserConnexion::class, cascade:["persist"])] // cascade persist
    #[Groups ([
        'read:User:item',
        'read:User:collection'
     ])]
    private Collection $userConnexions;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->userConnexions = new ArrayCollection();
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function setId(int $identifiant): static
    {
        $this->id = $identifiant;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserConnexion>
     */
    public function getUserConnexions(): Collection
    {
        return $this->userConnexions;
    }

    public function addUserConnexion(UserConnexion $userConnexion): static
    {
        if (!$this->userConnexions->contains($userConnexion)) {
            $this->userConnexions->add($userConnexion);
            $userConnexion->setUser($this);
        }

        return $this;
    }

    public function removeUserConnexion(UserConnexion $userConnexion): static
    {
        if ($this->userConnexions->removeElement($userConnexion)) {
            // set the owning side to null (unless already changed)
            if ($userConnexion->getUser() === $this) {
                $userConnexion->setUser(null);
            }
        }

        return $this;
    }
}


// namespace App\Entity;

// use ApiPlatform\Metadata\ApiResource;
// use App\Repository\UserRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
// use Symfony\Component\Security\Core\User\UserInterface;
// use DateTimeImmutable;
// use Symfony\Component\Serializer\Annotation\Groups;
// use ApiPlatform\Metadata\GetCollection;
// use ApiPlatform\Metadata\Post;
// use ApiPlatform\Metadata\Get;
// use ApiPlatform\Metadata\Put;
// use ApiPlatform\Metadata\Delete;
// use ApiPlatform\Metadata\Patch;

// #[ORM\Entity(repositoryClass: UserRepository::class)]
// #[ORM\Table(name: '`user`')]
// #[ApiResource (
//     operations: [
//         new GetCollection(normalizationContext: ['groups' => ['read:User:collection']]),
//         new Post(normalizationContext: ['groups' => ['read:User:item']]),
//         new Get(normalizationContext: ['groups' => ['read:User:item']]),
//         new Put(normalizationContext: ['groups' => ['read:User:item']]),
//         new Delete(normalizationContext: ['groups' => ['read:User:item']]),
//         new Patch(normalizationContext: ['groups' => ['read:User:item']]),
//     ]
// )
// ]

// class User implements UserInterface, PasswordAuthenticatedUserInterface
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private ?int $id = null;

//     #[ORM\Column(length: 180, unique: true)]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private ?string $email = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private array $roles = [];

//     /**
//      * @var string The hashed password
//      */
//     #[ORM\Column]
//     private ?string $password = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private ?\DateTimeImmutable $createdAt = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private ?\DateTimeImmutable $updatedAt = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private ?bool $enabled = null;

//     #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
//     private Collection $articles;

//     #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: true)]
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private Collection $comments;

//     #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserConnexion::class, cascade:["persist"])] // cascade persist
//     #[Groups ([
//         'read:User:item',
//         'read:User:collection'
//      ])]
//     private Collection $userConnexions;

//     public function __construct()
//     {
//         $this->createdAt = new DateTimeImmutable();
//         $this->updatedAt = new DateTimeImmutable();
//         $this->articles = new ArrayCollection();
//         $this->comments = new ArrayCollection();
//         $this->userConnexions = new ArrayCollection();
//     }

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getEmail(): ?string
//     {
//         return $this->email;
//     }

//     public function setEmail(string $email): static
//     {
//         $this->email = $email;

//         return $this;
//     }

//     /**
//      * A visual identifier that represents this user.
//      *
//      * @see UserInterface
//      */
//     public function getUserIdentifier(): string
//     {
//         return (string) $this->email;
//     }

//     /**
//      * @see UserInterface
//      */
//     public function getRoles(): array
//     {
//         $roles = $this->roles;
//         // guarantee every user at least has ROLE_USER
//         $roles[] = 'ROLE_USER';

//         return array_unique($roles);
//     }

//     public function setRoles(array $roles): static
//     {
//         $this->roles = $roles;

//         return $this;
//     }

//     /**
//      * @see PasswordAuthenticatedUserInterface
//      */
//     public function getPassword(): string
//     {
//         return $this->password;
//     }

//     public function setPassword(string $password): static
//     {
//         $this->password = $password;

//         return $this;
//     }

//     /**
//      * @see UserInterface
//      */
//     public function eraseCredentials(): void
//     {
//         // If you store any temporary, sensitive data on the user, clear it here
//         // $this->plainPassword = null;
//     }

//     public function getCreatedAt(): ?\DateTimeImmutable
//     {
//         return $this->createdAt;
//     }

//     public function setCreatedAt(\DateTimeImmutable $createdAt): static
//     {
//         $this->createdAt = $createdAt;

//         return $this;
//     }

//     public function getUpdatedAt(): ?\DateTimeImmutable
//     {
//         return $this->updatedAt;
//     }

//     public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
//     {
//         $this->updatedAt = $updatedAt;

//         return $this;
//     }

//     public function isEnabled(): ?bool
//     {
//         return $this->enabled;
//     }

//     public function setEnabled(bool $enabled): static
//     {
//         $this->enabled = $enabled;

//         return $this;
//     }

//     public function setId(int $identifiant): static
//     {
//         $this->id = $identifiant;

//         return $this;
//     }

//     /**
//      * @return Collection<int, Article>
//      */
//     public function getArticles(): Collection
//     {
//         return $this->articles;
//     }

//     public function addArticle(Article $article): static
//     {
//         if (!$this->articles->contains($article)) {
//             $this->articles->add($article);
//             $article->setUser($this);
//         }

//         return $this;
//     }

//     public function removeArticle(Article $article): static
//     {
//         if ($this->articles->removeElement($article)) {
//             // set the owning side to null (unless already changed)
//             if ($article->getUser() === $this) {
//                 $article->setUser(null);
//             }
//         }

//         return $this;
//     }

//     /**
//      * @return Collection<int, Comment>
//      */
//     public function getComments(): Collection
//     {
//         return $this->comments;
//     }

//     public function addComment(Comment $comment): static
//     {
//         if (!$this->comments->contains($comment)) {
//             $this->comments->add($comment);
//             $comment->setUser($this);
//         }

//         return $this;
//     }

//     public function removeComment(Comment $comment): static
//     {
//         if ($this->comments->removeElement($comment)) {
//             // set the owning side to null (unless already changed)
//             if ($comment->getUser() === $this) {
//                 $comment->setUser(null);
//             }
//         }

//         return $this;
//     }

//     /**
//      * @return Collection<int, UserConnexion>
//      */
//     public function getUserConnexions(): Collection
//     {
//         return $this->userConnexions;
//     }

//     public function addUserConnexion(UserConnexion $userConnexion): static
//     {
//         if (!$this->userConnexions->contains($userConnexion)) {
//             $this->userConnexions->add($userConnexion);
//             $userConnexion->setUser($this);
//         }

//         return $this;
//     }

//     public function removeUserConnexion(UserConnexion $userConnexion): static
//     {
//         if ($this->userConnexions->removeElement($userConnexion)) {
//             // set the owning side to null (unless already changed)
//             if ($userConnexion->getUser() === $this) {
//                 $userConnexion->setUser(null);
//             }
//         }

//         return $this;
//     }
// }
