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
    ){}

    // Method that use Newsletter API
    public function getNewslettersApi(): Response
    {
        $newsletters = $this->newsletterRepository->getUsersFromNewsletterWithDql();  // Get all users
        // dd('Test newsletters from CustomApiService', $newsletters);
        
        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($newsletters, JSON_FORCE_OBJECT));
            $response->headers->set('Content-Type', 'application/json');
        } catch(\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            ); 
        }

        return $response;
    }

    // Method that use Article API
    public function getArticleApi(): Response
    {
        $articles = $this->articleRepository->getArticleWithDql();  // Get all articles
        dd('Test article from CustomApiService', $articles);
        
        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($articles, JSON_FORCE_OBJECT));
            $response->headers->set('Content-Type', 'application/json');
        } catch(\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            ); 
        }

        return $response;
    }

}