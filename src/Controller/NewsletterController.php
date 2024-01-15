<?php

namespace App\Controller;

use App\Service\NewsletterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    //TODO mettre CRUD dans NewsletterService
    public function __construct(
        private NewsletterService $newsletterService   // use DI with controller for more than 1 method
    ){} 

    #[Route('/api/public_newsletters_post', name: 'newsletter_users_from_api')]
    public function getNewsletters()
    {
        $responseObject = $this->newsletterService->getUsersFromNewsletterAPI();

        return $responseObject;
    }
}