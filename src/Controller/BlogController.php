<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    // public function __construct(
    //     EntityManagerInterface $entityManagerInterface
    //     ) {}

    # Test Methods: 
    //dd($articleRepository)
    //dd($articleRepository->findAll());
    //dd($articleRepository->findBy(['published' => true]));

    #[Route('/blog', name: 'app_blog')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $article = new Article();  // All setters returns the same object
        $dateTime = new \DateTimeImmutable('now');  // Create a DateTimeImmutable variable to set date into a new article (in setCreatedAt argument)

        # Use setters from Entity Article. ALL FIELDS REQUIRED (ordered according to the db)
        $article->setTitle('TEST CREATE ARTICLE')
        ->setChapo('Velit proident culpa proident esse non nisi minim aute ipsum.')
        ->setContent('Velit proident culpa proident esse non nisi minim aute ipsum. Duis cupidatat nisi minim esse aute aliquip laborum ut reprehenderit nisi nisi. Occaecat dolore dolor occaecat cupidatat cillum. Sint sit aliquip commodo minim excepteur dolore magna velit sunt ea laboris. Est occaecat id quis est. Duis est id cupidatat quis id minim aliquip est minim amet officia est cupidatat. Incididunt dolore incididunt ut consequat sunt Lorem tempor exercitation elit ex velit esse et ad.')
        ->setCreatedAt($dateTime)
        ->setUpdatedAt($dateTime)
        ->setSlug('create-a-new-article')
        ->setPublished(true);

        $entityManager->persist($article);

        $entityManager->flush();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
