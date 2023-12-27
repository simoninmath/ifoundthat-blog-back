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

    #[Route('/api/article', name: 'article_from_api')]
    public function getArticles()
    {
        $responseObject = $this->customApiService->getArticleApi();
        
        return $responseObject; 
    }
}
