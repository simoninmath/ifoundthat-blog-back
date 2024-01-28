<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ApiResource]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[GetCollection]
    #[Get]
    #[Post]
    #[Put]
    #[Delete]
    #[ApiResource (
        operations: [
            new GetCollection(
                security: "is_granted('ROLE_ADMIN')",  # Only Admin can get form list
            ),            
            new Post(), # Post method is always public for a contact form
            
            new Get(
                security: "is_granted('ROLE_ADMIN')",  # Only Admin can get form list
            ),
            new Put(
                security: "is_granted('FORM_EDIT', object)",  # Voter's specifications
            ),
            new Delete(
                security: "is_granted('FORM_DELETE', object)",
            ),
            new Patch(
                security: "is_granted('FORM_EDIT', object)",
            ),
        ],
    )]

    private ?int $id = null;

    #[ORM\Column(length: 70)]
    #[Assert\Length(min: 2, max: 70, minMessage: 'Your name is too short.')]
    private ?string $name = null;

    #[ORM\Column(length: 70)]
    #[Assert\Email(message: 'This email {{ value }}" is not a valid email address.')]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Your message is too short.')]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
