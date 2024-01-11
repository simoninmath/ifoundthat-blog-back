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
    #[Route('/api/custom/protected_newsletters_get_collection', name: 'newsletters_get_collection', methods: ['GET'])]
    public function listNewsletters(NewsletterRepository $newsletterRepo): Response
    {
        $newslettersList = $newsletterRepo->findAll();

        return $this->json($newslettersList);
    }


    #CRUD: Get
    #[Route('/api/custom/protected_newsletters_get_by_id/{id}', name: 'newsletters_get_by_id', methods: ['GET'])]
    public function showNewsletter(Newsletter $newsletter): Response
    {
        return $this->json($newsletter);
    }


    #CRUD: Post
    #[Route('/api/custom/public_newsletters_post', name: 'newsletters_post', methods: ['POST'])]
    public function createNewsletter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newsletter = new Newsletter;  // Need to instanciate a new Newsletter Class here (not with DI), to avoid 500 error
        $data = json_decode($request->getContent(), true);

        $newsletter->setId($data['id']);
        $newsletter->setEmail($data['email']);

        $entityManager->persist($newsletter);
        $entityManager->flush();

        return $this->json($newsletter);
    }


    #CRUD: Put
    #[Route('/api/custom/protected_newsletters_put/{id}', name: 'newsletters_put', methods: ['PUT'])]
    public function updateNewsletter(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setId($data['id'] ?? $newsletter->getId());
        $newsletter->setEmail($data['email'] ?? $newsletter->getEmail());

        $entityManager->flush();

        return $this->json($newsletter);
    }

    
    #CRUD: Patch
    #[Route('/api/custom/protected_newsletters_patch/{id}', name: 'newsletters_patch', methods: ['PATCH'])]
    public function updateNewsletterWithPatch(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setId($data['id'] ?? $newsletter->getId());
        $newsletter->setEmail($data['email'] ?? $newsletter->getEmail());

        $entityManager->flush();

        return $this->json($newsletter);
    }


    #CRUD: Delete
    #[Route('/api/custom/protected_newsletters_delete/{id}', name: 'delete_newsletter', methods: ['DELETE'])]
    public function deleteNewsletter(Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($newsletter);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

}