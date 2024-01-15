<?php

namespace App\Controller;

use App\Service\CustomApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    //TODO DI à corriger
    public function __construct(
        private CustomApiService $customApiService  // use DI with controller for more than 1 method
    ){} 

    //TODO routes à modifier
    #[Route('/api/newsletters', name: 'newsletter_users_from_api')]
    public function getNewsletters()
    {
        $responseObject = $this->customApiService->getNewslettersApi();

        return $responseObject;
    }
}