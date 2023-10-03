<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class ApiController extends AbstractController
{
    #[Route('/api-proxy', name: 'api_proxy')]



public function apiProxy(Request $request): JsonResponse
{
    $apiUrl = 'https://api.gouv.fr/les-api/base-adresse-nationale?q=' . $request->query->get('q');

    $httpClient = new \GuzzleHttp\Client();
    $response = $httpClient->get($apiUrl);

    // Renvoie les données de l'API en tant que réponse JSON
    return new JsonResponse(json_decode($response->getBody()), $response->getStatusCode());
}

}
