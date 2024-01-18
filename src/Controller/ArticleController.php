<?php

namespace App\Controller;

use App\Service\CustomApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    // public function __construct(
    //     private CustomApiService $customApiService  // use DI with controller for more than 1 method
    // ){} 

    // #[Route('/api/public_articles_get_collection', name: 'get_all_articles_from_api')]
    // public function getAllArticles()
    // {
    //     $responseObject = $this->customApiService->getAllArticlesApi();
        
    //     return $responseObject;
    // }

    
    // #[Route('/api/public_articles_get_by_id', name: 'get_one_article_by_id_from_api')]
    // public function getOneArticle()
    // {
    //     $articleId = 1;
    //     $responseObject = $this->customApiService->getOneArticleApi($articleId);
        
    //     return $responseObject;
    // }


    // #[Route('/api/protected_article_post', name: 'create_article_from_api_with_post_method')]
    // public function createOneArticle(Request $request)
    // {
    //     // dd('affichage POST', $request);
    //     // Get data from POST method
    //     $request = json_decode($request->getContent(), true);
        
    //     // Use data to create a new article with EntityManager
    //     $article = $this->customApiService->createArticle($request);
    
    //     // Return the answer according to the condition
    //     if ($article) {
    //         return new JsonResponse(['message' => 'Article created'], Response::HTTP_CREATED);
    //     } else {
    //         return new JsonResponse(['message' => 'Failed to create article'], Response::HTTP_BAD_REQUEST);
    //     }
    // }
    
}
