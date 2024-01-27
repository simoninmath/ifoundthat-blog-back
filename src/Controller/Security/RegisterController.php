<?php

namespace App\Controller\Security;


use App\Dto\UserRegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class RegisterController extends AbstractController
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(
        #[MapRequestPayload] UserRegisterDto $userRegister,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {

        $user = new User();
        $user->setEmail($userRegister->email);
        $user->setPassword($passwordHasher->hashPassword($user, $userRegister->password));
        $user->setRoles(["ROLE_USER"]);
        $user->setEnabled(false);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([], 201);
    }
}
