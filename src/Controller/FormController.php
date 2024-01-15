<?php

namespace App\Controller;

use App\Service\FormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{

    public function __construct(
        private FormService $formService
    ){}

    #[Route('api/public_form_post', name: 'form_post')]
    public function fetchFormData(): Response
    {
        $responseObject = $this->formService->formPost();

        return $responseObject;
    }
}
