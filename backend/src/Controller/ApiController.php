<?php

namespace App\Controller;

use App\DTO\SubscribeRequest;
use App\DTO\UnSubscribeRequest;
use App\Handler\SubscriptionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
final class ApiController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly SubscriptionHandler $subscriptionHandler,
    ) {
    }

    #[Route('/subscribe', methods: ['GET', 'POST'])]
    public function subscribe(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $subscribeRequest = $this->serializer->deserialize($content, SubscribeRequest::class, 'json');
        $errors = $this->validateAndReturnErrors($subscribeRequest);
        if ($errors) {
            return $errors;
        }

        $message = $this->subscriptionHandler->subscribe($subscribeRequest);
        return new JsonResponse([
            "message" => $message,
            "status" => Response::HTTP_OK,
        ]);
    }

    #[Route('/unsubscribe', methods: ['POST'])]
    public function unsubscribe(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $unSubscribeRequest = $this->serializer->deserialize($content, UnSubscribeRequest::class, 'json');
        $errors = $this->validateAndReturnErrors($unSubscribeRequest);
        if ($errors) {
            return $errors;
        }

        $message = $this->subscriptionHandler->unSubscribe($unSubscribeRequest);
        return new JsonResponse([
            "message" => $message,
            "status" => Response::HTTP_OK,
        ]);
    }

    #[Route('/subscription-methods', methods: ['GET'])]
    public function getSubscriptionMethods(): JsonResponse
    {
        return new JsonResponse([
            "subscriptionMethods" => SubscribeRequest::SUBSCRIPTION_METHODS,
            "status" => Response::HTTP_OK,
        ]);
    }

    private function validateAndReturnErrors(object $requestDTO): ?JsonResponse
    {
        $errors = $this->validator->validate($requestDTO);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return new JsonResponse(
                ['errors' => $errorMessages],
                Response::HTTP_BAD_REQUEST
            );
        }

        return null;
    }

}