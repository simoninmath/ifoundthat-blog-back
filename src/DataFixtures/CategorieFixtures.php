<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Categorie;

class CategorieFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i=1; $i <= 5; $i++) 
        {
            $categorie = new Categorie();
            $categorie->setId($i);
            // Begin ID by nb 1
            $metadata = $manager->getClassMetadata(get_class($categorie));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $categorie->setName($this->faker->word(1));
            $manager->persist($categorie);
        }

        $manager->flush();
    }
}