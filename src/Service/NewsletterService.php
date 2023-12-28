<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\NewsletterRepository;

class NewsletterService
{
    private $httpClient;
    private $newsletterRepository;

    public function __construct(
        HttpClientInterface $httpClient, 
        NewsletterRepository $newsletterRepository)
    {
        $this->httpClient = $httpClient;
        $this->newsletterRepository = $newsletterRepository;
    }

    public function getUsersFromNewsletterAPI(): JsonResponse
    {
        try {
            $response = $this->httpClient->request('GET', 'https://127.0.0.1:8000/api/newsletter');

            $usersNl = $this->newsletterRepository->getUsersFromNewsletterWithDql();

            $response = new JsonResponse($usersNl, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json']);
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

