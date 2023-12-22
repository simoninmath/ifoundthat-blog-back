<?php

namespace App\Controller;

use App\Service\NewsletterService;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    // public function __construct(){} // use DI with controller for more than 1 method


    #[Route('/api/newsletter', name: 'newsletter_users_from_api')]
    public function getNewsletters(NewsletterRepository $newsletterRepository): JsonResponse
    {
        // dd('test route API newsletter');
        
        $newsletters = $newsletterRepository->getUsersFromNewsletterWithDql();  // Get all users
        // dd('Test newsletters from Dql', $newsletters);

        return $this->json($newsletters);
    }
}