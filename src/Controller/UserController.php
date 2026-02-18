<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Service\UserService;
use App\Dto\UserDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


final class UserController extends AbstractController
{
    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] UserDto $userDto, UserService $userService): JsonResponse 
    {
        $userService->createUser($userDto);

        return $this->json([
            'message' => 'User created successfully!'
        ], 201);
    }
    
    #[Route('/users', name: 'list_user', methods: ['GET'])]
    public function getAll(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findBy([], ['id' => 'ASC']);

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ];  
        }

        return $this->json($data);
    }

    #[Route('/users/{id}', name: 'show_user', methods: ['GET'])]
    public function getOne(int $id, UserRepository $userRepository): JsonResponse
    {

        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function update(int $id, Request $request, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $data = $request->toArray();

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['roles'])) {
            $user->setRoles($data['roles']);
        }

        $userRepository->save($user, true);

        return $this->json(['message' => 'User Updated!']);
    }

    #[Route('/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(int $id, DishRepository $dishRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }
        $userRepository->remove($user, true);

        return $this->json(['message' => 'User deleted successfully']);
    }
}

