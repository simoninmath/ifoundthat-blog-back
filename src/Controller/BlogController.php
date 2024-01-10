<?php

namespace App\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// use ApiPlatform\Api\UrlGeneratorInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BlogController extends AbstractController
{
    // $relativePat = '/api/articles';
    // $absoluteUrl = $this->urlGenerator->generate($relativePath, UrlGeneratorInterface::ABSOLUTE_URL);
    // include this instruction into "$location": UrlGeneratorInterface::ABSOLUTE_URL

    # Step 1: OK
    // #[Route('/article', name: 'TEST RESPONSE')]
    // public function index(): Response
    // {
    //     return $this->json([
    //         'message' => 'This is the BlogController file!',
    //         'path' => 'src/Controller/BlogController.php',
    //     ]);
    // }

    # Step 2:
    // #[Route('/api/articles', name: 'TEST JSON RESPONSE', methods: ['GET'])]
    // public function getArticleList(ArticleRepository $articleRepository): JsonResponse
    // {
    //     $articlesList = $articleRepository->findAll();

    //     return new JsonResponse([
    //         'articles' => $articlesList,
    //     ]);
    // }

    # Step 3:
    // #[Route('/api/articles', name: 'TEST SERIALIZED RESPONSE', methods: ['GET'])]
    // public function getArticleList(ArticleRepository $articleRepository, SerializerInterface $serializer): JsonResponse
    // {
    //     $articlesList = $articleRepository->findAll();
    //     $jsonArticlesList = $serializer->serialize($articlesList, 'json');
    //     return new JsonResponse($jsonArticlesList, Response::HTTP_OK, [], true);
    // } 

    #Step 4:
//     #[Route('/api/articles/{id}', name: 'TEST ARTICLE ID', methods: ['GET'])]
//     public function getArticleById(int $id, SerializerInterface $serializer, ArticleRepository $articleRepository): JsonResponse {

//         $article = $articleRepository->find($id);
//         if ($article) {
//             $jsonArticle = $serializer->serialize($article, 'json');
//             return new JsonResponse($jsonArticle, Response::HTTP_OK, [], true);
//         }
//         return new JsonResponse(null, Response::HTTP_NOT_FOUND);
//    }

    #Step 5:
    // #[Route('/api/articles/{id}', name: 'TEST PARAMCONVERTER', methods: ['GET'])]
    // public function getArticleById(Article $article, SerializerInterface $serializer): JsonResponse 
    // {
    //     $jsonArticle = $serializer->serialize($article, 'json');
    //     return new JsonResponse($jsonArticle, Response::HTTP_OK, ['accept' => 'json'], true);
    // }


    #CRUD: Get and Get Collection
    #[Route('/api/public_articles', name: 'TEST GET COLLECTION', methods: ['GET'])]
    public function getArticlesList(ArticleRepository $articleRepository, SerializerInterface $serializer): JsonResponse
    {
        $articlesList = $articleRepository->findAll();

        $jsonArticlesList = $serializer->serialize($articlesList, 'json', ['groups' => 'getArticles']);
        return new JsonResponse($jsonArticlesList, Response::HTTP_OK, [], true);
    }


    #[Route('/api/public_articles/{id}', name: 'TESTS GET BY ID', methods: ['GET'])]
    public function getArticleById(Article $articles, SerializerInterface $serializer): JsonResponse 
    {
        $jsonArticle = $serializer->serialize($articles, 'json', ['groups' => 'getArticles']);
        return new JsonResponse($jsonArticle, Response::HTTP_OK, [], true);
    }


    # CRUD: Delete method => WORKS!
    #[Route('/api/public_articles/{id}', name: 'TEST DELETE ARTICLE', methods: ['DELETE'])]
    public function deleteArticle(Article $article, EntityManagerInterface $entityManager): JsonResponse 
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    // # CRUD: Post method v3
    // #[Route('/api/articles', name:"TEST CREATE AN ARTICLE", methods: ['POST'])]
    // public function createArticle(Request $request, SerializerInterface $serializer, 
    // EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, 
    // CategorieRepository $categorieRepository): JsonResponse 
    // {
    //     $article = $serializer->deserialize($request->getContent(), Article::class, 'json');
    //     $content = $request->toArray();
    //     $idCategorie = $content['idCategorie'] ?? -1;
    //     $article->setCategorie($categorieRepository->find($idCategorie));
    //     $entityManager->persist($article);
    //     $entityManager->flush();

    //     $jsonArticle= $serializer->serialize($article, 'json', ['groups' => 'getArticles']);
    //     $location = $urlGenerator->generate('detailArticle', ['id' => $article->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

    //     return new JsonResponse($jsonArticle, Response::HTTP_CREATED, ["Location" => $location], true);
    // }


# CRUD: Post method v2
// #[Route('/api/articles', name:"TEST CREATE AN ARTICLE", methods: ['POST'])]
// public function createArticle(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse 
// {
//     // Désérialisation de la demande pour obtenir l'article
//     $article = $serializer->deserialize($request->getContent(), Article::class, 'json');

//     // Récupération de la catégorie à partir de l'article (supposons que la catégorie est incluse dans la demande)
//     $categorie = $article->getCategorie();

//     if ($categorie) {
//         // Vérifie si la catégorie existe déjà
//         $existingCategory = $entityManager->getRepository(Categorie::class)->findOneBy(['id' => $categorie->getId()]);
//         if (!$existingCategory) {
//             // Persistez la catégorie si elle n'existe pas déjà
//             $entityManager->persist($categorie);
//         }
//     } else {
//         // Si la catégorie n'est pas définie dans l'article, vous devez la définir ici ou gérer la création d'une nouvelle catégorie
//         // $categorie = new Categorie();
//         // $categorie->setName('Nouvelle catégorie');
//         // $entityManager->persist($categorie);
//         // $article->setCategorie($categorie);
//     }

//     // Persistez l'article
//     $entityManager->persist($article);
//     $entityManager->flush();

//     // Création de la réponse JSON et définition de l'emplacement
//     $jsonArticle = $serializer->serialize($article, 'json', ['groups' => 'getArticles']);
//     $location = $urlGenerator->generate('detailArticle', ['id' => $article->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

//     return new JsonResponse($jsonArticle, Response::HTTP_CREATED, ["Location" => $location], true);
// }


//     # CRUD: Post method v1
//     #[Route('/api/articles', name:"TEST CREATE AN ARTICLE", methods: ['POST'])]
//     public function createArticle(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse 
//     {

//         $article = $serializer->deserialize($request->getContent(), Article::class, 'json');
//         $entityManager->persist($article);
//         $entityManager->flush();

//         $jsonArticle = $serializer->serialize($article, 'json', ['groups' => 'getArticles']);
        
//         $location = $urlGenerator->generate('detailArticle', ['id' => $article->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

//         return new JsonResponse($jsonArticle, Response::HTTP_CREATED, ["Location" => $location], true);
//    }

// // Votre code pour récupérer la catégorie depuis le JSON
// $categorie = ...; // Récupération de la catégorie à partir des données JSON

// // Persistez la catégorie si elle n'existe pas déjà
// $entityManager->persist($categorie);

// // Création de l'article
// $article = $serializer->deserialize($request->getContent(), Article::class, 'json');
// $article->setCategorie($categorie); // Définir la catégorie pour l'article

// // Persistez l'article
// $entityManager->persist($article);
// $entityManager->flush();



   # CRUD: PUT method
   #[Route('/api/public_articles/{id}', name:"TEST UPDATE ARTICLE", methods:['PUT'])]
   public function updateArticle(Request $request, SerializerInterface $serializer, 
   Article $currentArticle, EntityManagerInterface $entityManager, 
   ArticleRepository $articleRepository): JsonResponse 
   {
       $updatedArticle = $serializer->deserialize($request->getContent(), 
               Article::class, 
               'json', 
               [AbstractNormalizer::OBJECT_TO_POPULATE => $currentArticle]);
       $content = $request->toArray();
       $idCategorie = $content['idArticle'] ?? -1;
       $updatedArticle->setCategorie($articleRepository->find($idCategorie));
       
       $entityManager->persist($updatedArticle);
       $entityManager->flush();
       return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
  }







    // public function __construct(
    //     EntityManagerInterface $entityManagerInterface
    //     ) {}

    # Test Methods: 
    //dd($articleRepository)
    //dd($articleRepository->findAll());
    //dd($articleRepository->findBy(['published' => true]));

    // #[Route('/blog', name: 'app_blog')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {

    //     $article = new Article();  // All setters returns the same object
    //     $dateTime = new \DateTimeImmutable('now');  // Create a DateTimeImmutable variable to set date into a new article (in setCreatedAt argument)

    //     # Use setters from Entity Article. ALL FIELDS REQUIRED (ordered according to the db)
    //     $article->setTitle('TEST CREATE ARTICLE')
    //     ->setChapo('Velit proident culpa proident esse non nisi minim aute ipsum.')
    //     ->setContent('Velit proident culpa proident esse non nisi minim aute ipsum. Duis cupidatat nisi minim esse aute aliquip laborum ut reprehenderit nisi nisi. Occaecat dolore dolor occaecat cupidatat cillum. Sint sit aliquip commodo minim excepteur dolore magna velit sunt ea laboris. Est occaecat id quis est. Duis est id cupidatat quis id minim aliquip est minim amet officia est cupidatat. Incididunt dolore incididunt ut consequat sunt Lorem tempor exercitation elit ex velit esse et ad.')
    //     ->setCreatedAt($dateTime)
    //     ->setUpdatedAt($dateTime)
    //     ->setSlug('create-a-new-article')
    //     ->setPublished(true);

    //     $entityManager->persist($article);

    //     $entityManager->flush();

    //     return $this->render('blog/index.html.twig', [
    //         'controller_name' => 'BlogController',
    //     ]);
    // }
}
