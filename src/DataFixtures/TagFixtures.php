<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class TagFixtures extends Fixture 
{

    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) 
        {
            $tag = new Tag();
            $tag->setId($i);
            // Begin ID by nb 1
            $metadata = $manager->getClassMetadata(get_class($tag));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $tag->setName($this->faker->word());
            // Create Object Reference
            $this->addReference('tag_'.$i, $tag); 
            $manager->persist($tag);
        }

        $manager->flush();
    }
    
}
