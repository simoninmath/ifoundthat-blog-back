<?php

namespace App\DataFixtures;

use App\Entity\Newsletter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsletterFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) 
        {
            $newsletter = new Newsletter();
            $newsletter->setEmail($this->faker->freeEmail());

            // Begin ID by nb 1
            $newsletter->setId($i);
            $metadata = $manager->getClassMetadata(get_class($newsletter));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->persist($newsletter);
        }
        
        $manager->flush();
        // $interruptor = rand(true, false);
            // if ($interruptor) 
            // {
            //     // Nb Comment Random
            //     $nbComment = rand(1, 5);
            //     for ($c = 1; $c <= $nbComment; $c++) 
            //     {
            //         $comment = new Comment();
            //         $comment->setArticle($this->getReference('article_' . $i));
            //         $comment->setUser($this->getReference('user_comment_' . rand(1, 6)));
            //         $comment->setId($idDb);
            //         // Begin ID by nb 1
            //         $metadata = $manager->getClassMetadata(get_class($comment));
            //         $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            //         $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            //         $comment->setContent($this->faker->paragraph());
            //         // Create Object Reference
            //         // $this->addReference('comment_'.$i, $comment); 
            //         $manager->persist($comment);
            //         $idDb++;
            //     }
            // } 
    }
}