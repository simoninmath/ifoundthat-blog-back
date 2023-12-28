<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomApiService
{
    public function __construct(
        private NewsletterRepository $newsletterRepository,
        private ArticleRepository $articleRepository,
        private EntityManager $entityManager
    ) {
    }

    // Method that use Newsletter API
    public function getNewslettersApi(): Response
    {
        $newsletters = $this->newsletterRepository->getUsersFromNewsletterWithDql();  // Get all users
        // dd('Test newsletters from CustomApiService', $newsletters);

        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($newsletters, JSON_FORCE_OBJECT));
            $response->headers->set('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }

        return $response;
    }

    // Method that use Article API to GET(collection) all articles from de database
    public function getAllArticlesApi(): Response
    {
        $allArticles = $this->articleRepository->getAllArticlesWithDql();  // Get all articles
        // dd('Test article from CustomApiService', $allArticles);

        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($allArticles, JSON_FORCE_OBJECT));
            $response->headers->set('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }

        return $response;
    }


    // Method that use Article API to GET one article from de database, by id
    public function getOneArticleApi(int $articleId): Response
    {
        $oneArticle = $this->articleRepository->getOneArticleByIdWithDql($articleId);
        // dd('Test article from CustomApiService', $oneArticle);

        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($oneArticle, JSON_FORCE_OBJECT));
            $response->headers->set('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }

        return $response;
    }


    // Method that use Article API to CREATE one article with POST method
    public function createArticle(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);
        dd('createArticle Method works!', $requestData);

        try {
            $newArticle = new Article();
            $newArticle->setTitle($requestData['title']);
            $newArticle->setChapo($requestData['chapo']);
            $newArticle->setContent($requestData['content']);
            $newArticle->setCreatedAt(new \DateTimeImmutable());
            $newArticle->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($newArticle);
            $this->entityManager->flush();

            $response = new JsonResponse(['message' => 'Creation status: created'], Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = new JsonResponse(
                ['error' => $exception->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
        }

        return $response;
    }
}
