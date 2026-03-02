<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DishRepository;
use App\Entity\Dish;
use App\Service\DishService;
use App\Dto\DishDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DishController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'You must be an admin to create a dish.')]
    #[Route('/dish', name: 'create_dish', methods: ['POST'])]
    public function create(#[MapRequestPayload] DishDTO $dto, DishService $dishService): JsonResponse
    {
        $dishService->createDish($dto);

        return $this->json([
            'message' => 'Dish created successfully'
        ], 201);
    }

    #[Route('/dish', name: 'list_dish', methods: ['GET'])]
    public function getAll(DishService $dishService): JsonResponse
    {
        $data = $dishService->getAllDishes();

        return $this->json($data);
    }

    #[Route('/dish/{id}', name: 'show_dish', methods: ['GET'])]
    public function getOne(int $id, DishService $dishService): JsonResponse
    {
        $data = $dishService->getDishById($id);

        return $this->json($data);
    }

    #[IsGranted('ROLE_ADMIN', message: 'You must be an admin to update a dish.')]
    #[Route('/dish/{id}', name: 'update_dish', methods: ['PUT'])]
    public function update(int $id, #[MapRequestPayload] DishDTO $dto, DishService $dishService): JsonResponse
    {
        $dishService->updateDish($id, $dto);

        return $this->json(['message' => 'Dish Updated!']);
    }

    #[IsGranted('ROLE_ADMIN', message: 'You must be an admin to delete a dish.')]
    #[Route('/dish/{id}', name: 'delete_dish', methods: ['DELETE'])]
    public function delete(int $id, DishService $dishService): JsonResponse
    {
        $data = $dishService->deleteDish($id);

        return $this->json(['message' => 'Dish deleted successfully']);
    }
}
