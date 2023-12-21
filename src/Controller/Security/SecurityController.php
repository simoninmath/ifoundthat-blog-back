<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_security_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login()
    {
        // return $this->render();
    }
}