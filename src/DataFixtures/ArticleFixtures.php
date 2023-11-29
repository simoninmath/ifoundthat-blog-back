<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i=1; $i <= 10; $i++) 
        {
            $article = new Article();
            $article->setId($i);
            // Begin ID by nb 1
            $metadata = $manager->getClassMetadata(get_class($article));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            // Get Object References
            $article->setUser($this->getReference('user_'.rand(1, 2)));
            $article->setCategorie($this->getReference('categorie_'.rand(1, 1)));
            $article->setTitle($this->faker->words(10, true));
            $article->setChapo($this->faker->paragraphs(1, true));
            $article->setContent($this->faker->paragraphs(3, true));
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategorieFixtures::class,
        ];
    }

}