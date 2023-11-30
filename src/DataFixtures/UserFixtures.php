<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserConnexion;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher) 
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $compteur = 1;
        $identifiant = 1;
        foreach ($this->getUserData() as [$password, $email, $roles, $enabled]) {
            $user = new User();

            // Pour avoir toujours les mêmes identifiants à chaque execution des fixtures :
            $user->setId($identifiant); //only for development, setId API
            $metadata = $manager->getClassMetadata(get_class($user));
            // rewind to 1 in MySQL DB, regenerate
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setEnabled($enabled);

            if (in_array('ROLE_ADMIN', $roles)) {
                $this->addReference('user_' . $compteur, $user);
                $compteur++;
            }
            $this->addReference('user_comment_' . $identifiant, $user);

            $interruptor = rand(true, false);
            if ($interruptor) {
                $nbConnexions = rand(1, 10);
                for ($i = 0; $i <= $nbConnexions; $i++) {
                    $userConnexion = new UserConnexion();
                    $user->addUserConnexion($userConnexion);
                    // $manager->persist($userConnexion);
                }
            }

            $manager->persist($user);
            $identifiant++;
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$password, $email, $roles];
            ['pass', 'user1@site.com', ['ROLE_USER'], true],
            ['pass', 'user2@site.com', ['ROLE_USER'], false],
            ['pass', 'user3@site.com', ['ROLE_USER'], true],
            ['pass', 'user4@site.com', ['ROLE_USER'], true],
            ['pass', 'admin1@site.com', ['ROLE_ADMIN'], true],
            ['pass', 'admin2@site.com', ['ROLE_ADMIN'], true],
        ];
    }


}
