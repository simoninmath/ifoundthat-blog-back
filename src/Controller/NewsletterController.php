<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// Controller responsible for CRUD operations on the Newsletter entity
class NewsletterController extends AbstractController
{

    // CRUD: Get Collection - Retrieve a list of all newsletters
    #[Route('/api/custom/protected_newsletters_get_collection', name: 'newsletters_get_collection', methods: ['GET'])]  // REST End-Point
    public function listNewsletters(NewsletterRepository $newsletterRepo): Response
    {
        $newslettersList = $newsletterRepo->findAll();  // Using findAll() method to get all data from newsletter database

        return $this->json($newslettersList);  // Return a JSON object as a response
    }


    // CRUD: Get - Retrieve a specific newsletter by ID
    #[Route('/api/custom/protected_newsletters_get_by_id/{id}', name: 'newsletters_get_by_id', methods: ['GET'])]  // REST End-Point
    public function showNewsletter(Newsletter $newsletter): Response
    {
        return $this->json($newsletter);  // Return a JSON object as a response
    }


    // CRUD: Post - Create a new newsletter (REST End-Point)
    #[Route('/api/custom/public_newsletters_post', name: 'newsletters_post', methods: ['POST'])]  
    public function createNewsletter(
        Request $request, 
        EntityManagerInterface $entityManager): Response
    {
        // Need to instanciate a new Newsletter Class here (not with DI), to avoid 500 error
        $newsletter = new Newsletter;  
        $data = json_decode($request->getContent(), true);

        // Create a new newsletter object
        $newsletter->setEmail($data['email']);  

        // Doctrine method that persist data before writing it into database
        $entityManager->persist($newsletter);

        // Doctrine method that write data into database
        $entityManager->flush();
        
        // Return a JSON object as a response
        return $this->json($newsletter);  
    }


    // CRUD: Put - Update a newsletter by replacing its data
    #[Route('/api/custom/protected_newsletters_put/{id}', name: 'newsletters_put', methods: ['PUT'])]
    public function updateNewsletter(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setId($data['id'] ?? $newsletter->getId());
        $newsletter->setEmail($data['email'] ?? $newsletter->getEmail());

        $entityManager->flush();

        return $this->json($newsletter);
    }

    
    // CRUD: Patch - Update a newsletter with partial data
    #[Route('/api/custom/protected_newsletters_patch/{id}', name: 'newsletters_patch', methods: ['PATCH'])]
    public function updateNewsletterWithPatch(Request $request, Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $newsletter->setId($data['id'] ?? $newsletter->getId());
        $newsletter->setEmail($data['email'] ?? $newsletter->getEmail());

        $entityManager->flush();

        return $this->json($newsletter);
    }


    // CRUD: Delete - Delete a newsletter
    #[Route('/api/custom/protected_newsletters_delete/{id}', name: 'delete_newsletter', methods: ['DELETE'])]
    public function deleteNewsletter(Newsletter $newsletter, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($newsletter);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

}