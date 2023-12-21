<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_security_')]
class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function login()
    {
        //return $this->render();
    }
}