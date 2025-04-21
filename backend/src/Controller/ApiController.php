<?php

namespace App\Controller;

use App\DTO\SubscribeRequest;
use App\DTO\UnSubscribeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
final class ApiController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }


    #[Route('/subscribe', methods: ['GET', 'POST'])]
    public function subscribe(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $subscribeRequest = $this->serializer->deserialize($content, SubscribeRequest::class, 'json');

        return new JsonResponse($subscribeRequest);
    }

    #[Route('/unsubscribe', methods: ['POST'])]
    public function unsubscribe(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $unSubscribeRequest = $this->serializer->deserialize($content, UnSubscribeRequest::class, 'json');

        return new JsonResponse($unSubscribeRequest);
    }
}