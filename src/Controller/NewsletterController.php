<?php

namespace App\Controller;

use App\Service\NewsletterService;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    public function __construct(
        private NewsletterService $newsletterService
    ){}


    #[Route('/api/newsletter', name: 'newsletter_users_from_api')]
    public function getUsers(NewsletterService $newsletterService, NewsletterRepository $newsletterRepository): JsonResponse
    {
        // Use Service to get Users from API
        $usersFromAPI = $newsletterService->getUsersFromNewsletterAPI();

        return $this->json([
            'users_from_api' => $usersFromAPI,
        ]);
    }
}
