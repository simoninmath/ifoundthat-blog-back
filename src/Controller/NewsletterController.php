<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    #CRUD: Get Collection
    #[Route('/api/public_newsletters', name: 'get_collection_newsletters_list', methods: ['GET'])]
    public function listNewsletters(NewsletterRepository $newsletterRepo): Response
    {
        $newslettersList = $newsletterRepo->findAll();

        return $this->json($newsletterRepo);
    }


     #CRUD: Get
    #[Route('/api/public_newsletters/{id}', name: 'get_newsletter_by_id', methods: ['GET'])]
    public function showNewsletter(Newsletter $newsletter): Response
    {
        return $this->json($newsletter);
    }


    #CRUD: Post
    #[Route('/api/public_newsletters', name: 'create_newsletter', methods: ['POST'])]
    public function createNewsletter(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setTitle($data['title']);
        $newsletter->setContent($data['content']);

        $entityManager->persist($newsletter);
        $entityManager->flush();

        return $this->json($newsletter);
    }


    #CRUD: Post
    #[Route('/api/public_newsletters/{id}', name: 'update_newsletter', methods: ['PUT'])]
    public function updateNewsletter(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setTitle($data['title'] ?? $newsletter->getTitle());
        $newsletter->setContent($data['content'] ?? $newsletter->getContent());

        $entityManager->flush();

        return $this->json($newsletter);
    }


    #CRUD: Post
    #[Route('/api/public_newsletters/{id}', name: 'delete_newsletter', methods: ['DELETE'])]
    public function deleteNewsletter(Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($newsletter);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}


// namespace App\Controller;

// use App\Service\CustomApiService;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;

// class NewsletterController extends AbstractController
// {

//     public function __construct(
//         private CustomApiService $customApiService  // use DI with controller for more than 1 method
//     ){} 

//     #[Route('/api/newsletters', name: 'newsletter_users_from_api')]
//     public function getNewsletters()
//     {
//         $responseObject = $this->customApiService->getNewslettersApi();

//         return $responseObject;
//     }
// }