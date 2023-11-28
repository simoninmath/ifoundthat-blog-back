<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

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