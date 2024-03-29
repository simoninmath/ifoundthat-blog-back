<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Validator\Constraints as Assert; // Import allow using Assert


#[ApiResource (
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['read:Article:collection']]), # Create an instance of GetCollection operation and normalize it with groups option
        
        new Post(
            security: "is_granted('ROLE_ADMIN')",  # Post method is only available for admin
        ),
        new Get(
            normalizationContext: ['groups' => ['read:Article:item']]
        ),
        new Put(
            security: "is_granted('ARTICLE_EDIT', object)",  # Voter's specifications
        ),
        new Delete(
            security: "is_granted('ARTICLE_DELETE', object)",
        ),
        new Patch(
            security: "is_granted('ARTICLE_EDIT', object)",
        ),
        new Get(
            normalizationContext: ['groups' => ['read:Article:item:public']],  # Specify the which request is public
            name:'public_article',
            uriTemplate:'public_articles/{id}'
        ), 
        new GetCollection(
            normalizationContext: ['groups' => ['read:Article:collection:public']],
            name:'public_articles',
            uriTemplate:'public_articles'
        ), 
    ],
)]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups ([  # Apply normalize options to modify the content of the request returned
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    #[Assert\Length(min: 2, max: 30, minMessage: 'Title must be 30 characters max.')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    #[Assert\Length(min: 2, max: 70, minMessage: 'Chapo must be 70 characters max.')]
    private ?string $chapo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    #[Assert\Length(min: 2, max: 3500, minMessage: 'Article content must be 3500 characters max.')]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: true)]  
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'articles', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class, orphanRemoval: true)]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'article')]
    #[Groups ([
        'read:Article:item',
        'read:Article:collection',
        'read:Article:item:public',
        'read:Article:collection:public'
    ])]
    private Collection $tags;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo): static
    {
        $this->chapo = $chapo;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function setId(int $identifiant): static
    {
        $this->id = $identifiant;

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
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addArticle($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeArticle($this);
        }

        return $this;
    }
}


// namespace App\Entity;

// use ApiPlatform\Metadata\ApiFilter;
// use ApiPlatform\Metadata\ApiResource;
// use App\Repository\ArticleRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Serializer\Annotation\Groups;
// use ApiPlatform\Metadata\GetCollection;
// use ApiPlatform\Metadata\Post;
// use ApiPlatform\Metadata\Get;
// use ApiPlatform\Metadata\Put;
// use ApiPlatform\Metadata\Delete;
// use ApiPlatform\Metadata\Patch;
// use App\ApiFilter\SearchFilter;

// #[ApiResource (
//     operations: [
//         new GetCollection(
//             normalizationContext: ['groups' => ['read:Article:collection']]), # Create an instance of GetCollection operation and normalize it with groups option
//         new Post(
//             security: "is_granted('ARTICLE_CREATE', object)",
//             name:'protected_article_post',
//             uriTemplate:'protected_article_post'
//         ),
//         new Get(
//             security: "is_granted('ARTICLE_READ', object)",
//             normalizationContext: ['groups' => ['read:Article:item']]
//         ),
//         new Put(
//             security: "is_granted('ARTICLE_EDIT', object)",
//         ),
//         new Delete(
//             security: "is_granted('ARTICLE_DELETE', object)",
//         ),
//         new Patch(
//             security: "is_granted('ARTICLE_EDIT', object)",
//         ),
//         new Get(
//             normalizationContext: ['groups' => ['read:Article:item:public']],  # Specify the which request is public
//             name:'public_article',
//             uriTemplate:'public_articles_get_by_id/{id}'
//         ), 
//         new GetCollection(
//             normalizationContext: ['groups' => ['read:Article:collection:public']],
//             name:'public_articles',
//             uriTemplate:'public_articles_get_collection'
//         ), 
//     ],
// )]
// #[ORM\Entity(repositoryClass: ArticleRepository::class)]
// class Article
// {
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column]
//     #[Groups ([  # Apply normalize options to modify the content of the request returned
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?int $id = null;

//     #[ApiFilter(SearchFilter::class)]
//     #[ORM\Column(length: 255)]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?string $title = null;

//     #[ApiFilter(SearchFilter::class)]
//     #[ORM\Column(type: Types::TEXT)]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?string $chapo = null;

//     #[ApiFilter(SearchFilter::class)]
//     #[ORM\Column(type: Types::TEXT)]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?string $content = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?\DateTimeImmutable $createdAt = null;

//     #[ORM\Column]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?\DateTimeImmutable $updatedAt = null;

//     #[ORM\ManyToOne(inversedBy: 'articles')]
//     #[ORM\JoinColumn(nullable: false)]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private ?Categorie $categorie = null;

//     #[ORM\ManyToOne(inversedBy: 'articles', targetEntity: User::class)]
//     #[ORM\JoinColumn(nullable: false)]
//     private ?User $user = null;

//     #[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class, orphanRemoval: true)]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private Collection $comments;

//     #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'article')]
//     #[Groups ([
//         'read:Article:item',
//         'read:Article:collection',
//         'read:Article:item:public',
//         'read:Article:collection:public'
//     ])]
//     private Collection $tags;

//     public function __construct()
//     {
//         $this->createdAt = new \DateTimeImmutable();
//         $this->updatedAt = new \DateTimeImmutable();
//         $this->comments = new ArrayCollection();
//         $this->tags = new ArrayCollection();
//     }

//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     public function getTitle(): ?string
//     {
//         return $this->title;
//     }

//     public function setTitle(string $title): static
//     {
//         $this->title = $title;

//         return $this;
//     }

//     public function getChapo(): ?string
//     {
//         return $this->chapo;
//     }

//     public function setChapo(string $chapo): static
//     {
//         $this->chapo = $chapo;

//         return $this;
//     }

//     public function getContent(): ?string
//     {
//         return $this->content;
//     }

//     public function setContent(string $content): static
//     {
//         $this->content = $content;

//         return $this;
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

//     public function getCategorie(): ?Categorie
//     {
//         return $this->categorie;
//     }

//     public function setCategorie(?Categorie $categorie): static
//     {
//         $this->categorie = $categorie;

//         return $this;
//     }

//     public function getUser(): ?user
//     {
//         return $this->user;
//     }

//     public function setUser(?user $user): static
//     {
//         $this->user = $user;

//         return $this;
//     }

//     public function setId(int $identifiant): static
//     {
//         $this->id = $identifiant;

//         return $this;
//     }

//     /**
//      * @return Collection<int, Comment>
//      */
//     public function getComments(): Collection
//     {
//         return $this->comments;
//     }

//     public function setComment(Comment $comment): static
//     {
//         if (!$this->comments->contains($comment)) {
//             $this->comments->add($comment);
//             $comment->setArticle($this);
//         }

//         return $this;
//     }

//     public function deleteComment(Comment $comment): static
//     {
//         if ($this->comments->removeElement($comment)) {
//             // set the owning side to null (unless already changed)
//             if ($comment->getArticle() === $this) {
//                 $comment->setArticle(null);
//             }
//         }

//         return $this;
//     }

//     /**
//      * @return Collection<int, Tag>
//      */
//     public function getTags(): Collection
//     {
//         return $this->tags;
//     }

//     public function setTag(Tag $tag): static
//     {
//         if (!$this->tags->contains($tag)) {
//             $this->tags->add($tag);
//             $tag->addArticle($this);
//         }

//         return $this;
//     }

//     public function removeTag(Tag $tag): static
//     {
//         if ($this->tags->removeElement($tag)) {
//             $tag->removeArticle($this);
//         }

//         return $this;
//     }
// }