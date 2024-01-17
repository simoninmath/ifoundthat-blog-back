<?php

namespace App\Service;

use App\Entity\Form;
use App\Repository\FormRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
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

    /**
     * Handles a form submission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function formPost(Request $request)
    {
        // Decode JSON data from the request
        $requestData = json_decode($request->getContent(), true);

        try {
            // Use form data in the HTTP request
            $response = $this->httpClient->request('POST', 'https://127.0.0.1:8000/api/public_form_post', [
                'json' => $requestData,
            ]);

            // Create and save form data to the appropriate entity
            $formData = new Form();
            $formData->setName($requestData['name']);
            $formData->setEmail($requestData['email']);
            $formData->setMessage($requestData['message']);
            $this->formRepo->save($formData);

            // Return the response after the HTTP request
            return $response;
        } catch (HttpExceptionInterface $httpException) {
            // Handle specific HTTP exceptions (400)
            return new JsonResponse(
                'HTTP error! ' . $httpException->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        } catch (\Exception $exception) {
            // Handle other exceptions
            return new JsonResponse(
                'Error! ' . $exception->getMessage(),
                JsonResponse::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }
    }
}


// namespace App\Service;

// use App\Entity\Form;
// use App\Repository\FormRepository;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
// use Symfony\Contracts\HttpClient\HttpClientInterface;

// class FormService
// {
//     private $httpClient;
//     private $formRepo;

//     public function __construct(
//         HttpClientInterface $httpClient,
//         FormRepository $formRepo
//     ){
//         $this->httpClient = $httpClient;
//         $this->formRepo = $formRepo;
//     }

//     public function formPost(Request $request)
//     {
//         $requestData = json_decode($request->getContent(), true);

//         try {
//             // Utilise les données du formulaire dans la requête HTTP
//             $response = $this->httpClient->request('POST', 'https://127.0.0.1:8000/api/public_form_post', [
//                 'json' => $requestData,
//             ]);

//             // Crée et sauvegarde les données du formulaire dans l'entité appropriée
//             $formData = new Form();
//             $formData->setName($requestData['name']);
//             $formData->setEmail($requestData['email']);
//             $formData->setMessage($requestData['message']);
//             $this->formRepo->save($formData);

//             // Renvoie la réponse après la requête HTTP
//             return $response;
//         } catch (HttpExceptionInterface $httpException) {
//             // Gère les exceptions HTTP spécifiques
//             return new JsonResponse(
//                 'HTTP error!'.$httpException->getMessage(),
//                 JsonResponse::HTTP_BAD_REQUEST,
//                 ['Content-Type' => 'application/json']
//             );
//         } catch (\Exception $exception) {
//             // Gère les autres exceptions
//             return new JsonResponse(
//                 'Error!' . $exception->getMessage(),
//                 JsonResponse::HTTP_BAD_REQUEST,
//                 ['Content-Type' => 'application/json']
//             );
//         }
//     }
// }