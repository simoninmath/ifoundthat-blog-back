<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserConnexionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: UserConnexionRepository::class)]
#[ApiResource (
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:UserConnexion:collection']]),
        new Post(),
        new Get(normalizationContext: ['groups' => ['read:UserConnexion:item']]),
        new Put(),
        new Delete(),
        new Patch(),
    ]
)
]

class UserConnexion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([
        'read:UserConnexion:item',
        'read:UserConnexion:collection'
     ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups ([
        'read:UserConnexion:item',
        'read:UserConnexion:collection'
     ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'userConnexions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups ([
        'read:UserConnexion:item',
        'read:UserConnexion:collection'
     ])]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
