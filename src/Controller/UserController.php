<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{

    public function __construct(private UserService $userService)
    {

    }

    #[Route('/api/user', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userDto = new UserDTO();
        $form = $this->createForm(UserType::class, $userDto);
        $form->submit($data);
        if ($form->isValid()) {
            $createdUser = $this->userService->createUser($userDto);
            return new JsonResponse([
                'message' => 'User created successfully',
            ], JsonResponse::HTTP_CREATED);
        }
        return new JsonResponse([
            'error' => 'Validation error',
            'details' => (string)$form->getErrors(true, false),
        ], JsonResponse::HTTP_BAD_REQUEST);


    }

}
