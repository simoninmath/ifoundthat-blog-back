<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use App\Repository\NewsletterRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomApiService
{
    public function __construct(
        private NewsletterRepository $newsletterRepository,
        private ArticleRepository $articleRepository,
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

    // Method that use Article API
    public function getAllArticlesApi(): Response
    {
        $allArticles = $this->articleRepository->getAllArticlesWithDql();  // Get all articles
        dd('Test article from CustomApiService', $allArticles);

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
    

}