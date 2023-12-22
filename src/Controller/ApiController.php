<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class ApiController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    #[Route('/api/newsletter', name: 'api_newsletter_userlist', methods: ['GET'])]
    public function getUsersFromNewsletter(): JsonResponse
    {
        $usersNl = $this->userRepository->getUsersNewsletterWithDql();

        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($usersNl, JSON_FORCE_OBJECT));
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