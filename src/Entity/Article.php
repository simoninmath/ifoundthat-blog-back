<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Entity(name: '`article`')]

class Article
{
    // Title
    // Chapo
    // Body
    // Images
    // Nb views
    // Nb coments

    //Getters
    //Setters
}