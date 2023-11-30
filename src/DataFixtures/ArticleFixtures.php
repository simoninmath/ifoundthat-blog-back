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

        for ($i = 1; $i <= 10; $i++) {

            $article = new Article();
            $article->setId($i);
            // Begin ID by nb 1
            $metadata = $manager->getClassMetadata(get_class($article));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            // Get Object References
            $article->setUser($this->getReference('user_' . rand(1, 2)));
            $article->setCategorie($this->getReference('categorie_' . rand(1, 5)));

            //TODO a refactoriser
            $tab = $this->faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'], null);
            // dd($tab);
            $interruptor = rand(true, false);
            if ($interruptor) {
                foreach ($tab as $value) {
                    $article->addTag($this->getReference('tag_'.$value));
                }
            }

            $article->setTitle($this->faker->words(10, true));
            $article->setChapo($this->faker->paragraphs(1, true));
            $article->setContent($this->faker->paragraphs(3, true));
            // Create Object Reference
            $this->addReference('article_' . $i, $article);
            $manager->persist($article);
        }

        $manager->flush();
    }

    // Interface who get load fixture order
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategorieFixtures::class,
            TagFixtures::class,
        ];
    }
}