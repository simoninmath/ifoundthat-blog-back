<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Routing\Annotation\Route;
// use App\Entity\User;
// use Symfony\Component\HttpFoundation\Request;

// class ApiController extends AbstractController
// {

//     #[Route('api/users', name:'api_users_list', methods: ['GET'])]
//     public function getUsers(Request $request): JsonResponse
//     {
//         $userRepository = $request->get(User::class);
//         $users = $userRepository->findAll();

//         $formattedUsers = [];
//         foreach ($users as $user) {
//             $formattedUsers[] = [
//                 'email' => $user->getEmail(),
//                 'role' => $user->getRole(),
//                 'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
//             ];
//         }

//         return $this->json($formattedUsers);
//     }
// }

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private UserRepository $userRepository,
    ){}

    #[Route('/api/users', name: 'api_users_list', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        // $entityManager = $this->doctrine;
        
        // $userRepository = $entityManager->getRepository(User::class);
        
        $users = $userRepository->findAll();

        $formattedUsers = [];
        foreach ($users as $user) {
            $formattedUsers[] = [
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
                'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }

        return $this->json($formattedUsers);
    }

    try {
        $response = new JsonResponse();
        $response->setContent(json_encode($users, JSON_FORCE_OBJECT));
        $response->headers->set('Content-Type', 'application/json');
    } catch(\Exception $e) {
        $response = new JsonResponse(
            'error_insertion_new_ingredient_par_api' . $e->getMessage(),
            JsonResponse::HTTP_BAD_REQUEST,
            ['content-type' => 'application/json']
        ); 
    }
}