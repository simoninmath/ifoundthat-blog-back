<?php

namespace App\DataFixtures;

use App\Entity\Log;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LogFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        // Count always start to 1 (not 0)
        for ($i = 1; $i <= 10; $i++) {
            $log = new Log();
            $log->setIpAddress($this->faker->ipv4());

            // Regenerate MySQL id to 1
            $log->setId($i); 
            $metadata = $manager->getClassMetadata(get_class($log));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->persist($log);
        }

        $manager->flush();
    }
}
