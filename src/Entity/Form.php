<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
// use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
// use ApiPlatform\Metadata\Get;
// use ApiPlatform\Metadata\Put;
// use ApiPlatform\Metadata\Delete;
// use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ApiResource]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // #[GetCollection]
    // #[Get]
    #[Post]
    // #[Put]
    // #[Delete]
    #[ApiResource(
        operations: [
            new Post(
                // security: "is_granted('FORM_POST', object)",  //TODO mettre en place le Voter
                normalizationContext: ['groups' => ['write:Form:public']],
                name:'public_form_post',
                uriTemplate:'public_form_post'
            ),
        ]
    )]
    // #[Groups([
    //     'write:Form:public'
    // ])]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    // #[Groups([
    //     'write:Form:public'
    // ])]
    private ?string $name = null;

    #[ORM\Column(length: 70)]
    // #[Groups([
    //     'write:Form:public'
    // ])]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    // #[Groups([
    //     'write:Form:public'
    // ])]
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
