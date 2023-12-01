<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $idDb = 1;
        for ($i = 1; $i <= 10; $i++) {
            $interruptor = rand(true, false);
            if ($interruptor) {

                // Nb Comment Random
                $nbComment = rand(1, 5);
                for ($c = 1; $c <= $nbComment; $c++) {
                    $comment = new Comment();
                    $comment->setArticle($this->getReference('article_' . $i));
                    $comment->setUser($this->getReference('user_comment_' . rand(1, 6)));

                    // Begin ID by nb 1
                    $comment->setId($idDb);
                    $metadata = $manager->getClassMetadata(get_class($comment));
                    $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

                    $comment->setContent($this->faker->paragraph());
                    // Create Object Reference
                    // $this->addReference('comment_'.$i, $comment); 
                    $manager->persist($comment);
                    $idDb++;
                }
            }
        }

        $manager->flush();
    }

    // Interface who get load fixture order
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ArticleFixtures::class,
        ];
    }
}