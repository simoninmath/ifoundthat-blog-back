<?php

namespace App\Service;

use App\Repository\FormRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FormService
{
    private $httpClient;
    private $formRepo;

    public function __construct(
        HttpClientInterface $httpClient,
        FormRepository $formRepo
    ){
        $this->httpClient = $httpClient;
        $this->formRepo = $formRepo;
    }

    public function formPost()
    {
        try {
            $response = $this->httpClient->request('POST', 'https://127.0.0.1:8000/api/public_form_post');

            $formData = $this->formRepo->getUsersFromNewsletterWithDql();

            $response = new JsonResponse($formData, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json']);
        } catch (\Exception $exception) {
            $response = new JsonResponse(
                'error!' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        return $response;
    }
}