<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
#[ApiResource (
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:Newsletter:collection']]),
        new Post(),
        new Get(normalizationContext: ['groups' => ['read:Newsletter:item']]),
        new Put(),
        new Delete(),
        new Patch(),
    ]
)
]

class Newsletter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([
        'read:Newsletter:item',
        'read:Newsletter:collection'
     ])]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    #[Groups ([
        'read:Newsletter:item',
        'read:Newsletter:collection'
     ])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups ([
        'read:Newsletter:item',
        'read:Newsletter:collection'
     ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $identifiant): static
    {
        $this->id = $identifiant;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
