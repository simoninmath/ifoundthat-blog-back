<?php

namespace App\Controller;

use App\Service\CustomApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct(
        private CustomApiService $customApiService  // use DI with controller for more than 1 method
    ){} 

    #[Route('/api/articles', name: 'all_articles_from_api')]
    public function getAllArticles()
    {
        $responseObject = $this->customApiService->getAllArticlesApi();
        
        return $responseObject;
    }

    // #[Route('/api/article', name: 'one_article_by_id_from_api')]
    // public function getOneArticle()
    // {
    //     $articleId = 1;
    //     $responseObject = $this->customApiService->getOneArticleApi($articleId);
        
    //     return $responseObject; 
    // }

}
