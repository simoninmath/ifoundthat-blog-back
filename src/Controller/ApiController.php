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

    #[Route('/api/toto', name: 'api_testing', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->userRepository->getUsersInfoWithDql();

        try {
            $response = new JsonResponse();
            $response->setContent(json_encode($users, JSON_FORCE_OBJECT));
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