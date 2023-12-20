<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource (
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['read:Categorie:collection']]),
        new Post(),
        new Get(normalizationContext: ['groups' => ['read:Categorie:item']]),
        new Put(),
        new Delete(),
        new Patch(),
    ]
)
]

class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([
        'read:Categorie:item',
        'read:Categorie:collection'
     ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups ([
        'read:Categorie:item',
        'read:Categorie:collection'
     ])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    #[Groups ([
        'read:Categorie:item',
        'read:Categorie:collection'
     ])]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    // Getter Categorie
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    // Setters Categorie
    public function setName(string $name): static
    {
        $this->name = $name;

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
    
    // CRUD Categorie
    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }
}
