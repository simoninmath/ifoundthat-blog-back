<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: LogRepository::class)]
#[ApiResource (
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:Log:collection']]),
        new Post(),
        new Get(normalizationContext: ['groups' => ['read:Log:item']]),
        new Put(),
        new Delete(),
        new Patch(),
    ]
)
]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([
        'read:Log:item',
        'read:Log:collection'
     ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups ([
        'read:Log:item',
        'read:Log:collection'
     ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups ([
        'read:Log:item',
        'read:Log:collection'
     ])]
    private string $ipAddress = '';

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
