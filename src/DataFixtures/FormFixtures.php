<?php

namespace App\DataFixtures;

use App\Entity\Form;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;   // Use this import. Not: Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\Persistence\ObjectManager;

class FormFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) 
        {
            $form = new Form();
            $form->setName($this->faker->firstName());
            $form->setEmail($this->faker->freeEmail());
            $form->setMessage($this->faker->text);

            // Begin ID by nb 1
            $form->setId($i);
            $metadata = $manager->getClassMetadata(get_class($form));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->persist($form);
        }
        
        $manager->flush();
    }
}
