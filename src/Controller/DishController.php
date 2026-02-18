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

final class DishController extends AbstractController
{
    #[Route('/dish', name: 'create_dish', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] DishDTO $dto, DishService $dishService): JsonResponse
    {   
        $dishService->createDish($dto);

        return $this->json([
            'message' => 'Dish created successfully'
        ], 201);
    }

    #[Route('/dish', name: 'list_dish', methods: ['GET'])]
    public function getAll(DishRepository $dishRepository): JsonResponse
    {
        $dishes = $dishRepository->findBy([], ['id' => 'ASC']);

        $data = [];

        foreach ($dishes as $dish) {
            $data[] = [
                'id' => $dish->getId(),
                'name' => $dish->getName(),
                'description' => $dish->getDescription(),
                'price' => $dish->getPrice(),
                'category' => $dish->getCategory(),
            ];  
        }

        return $this->json($data);
    }

    #[Route('/dish/{id}', name: 'show_dish', methods: ['GET'])]
    public function getOne(int $id, DishRepository $dishRepository): JsonResponse
    {

        $dish = $dishRepository->find($id);

        if (!$dish) {
            return $this->json(['message' => 'Prato não encontrado'], 404);
        }

        return $this->json([
            'id' => $dish->getId(),
            'name' => $dish->getName(),
            'description' => $dish->getDescription(),
            'price' => $dish->getPrice(),
            'category' => $dish->getCategory(),
        ]);
    }

    #[Route('/dish/{id}', name: 'update_dish', methods: ['PUT'])]
    public function update(int $id, Request $request, DishRepository $dishRepository): JsonResponse
    {
        $dish = $dishRepository->find($id);

        if (!$dish) {
            return $this->json(['message' => 'Dish not found'], 404);
        }

        $data = $request->toArray();

        if (isset($data['name'])) {
            $dish->setName($data['name']);
        }
        if (isset($data['description'])) {
            $dish->setDescription($data['description']);
        }
        if (isset($data['price'])) {
            $dish->setPrice($data['price']);
        }
        if (isset($data['category'])) {
            $dish->setCategory($data['category']);
        }

        $dishRepository->add($dish, true);

        return $this->json(['message' => 'Dish Updated!']);
    }

    #[Route('/dish/{id}', name: 'delete_dish', methods: ['DELETE'])]
    public function delete(int $id, DishRepository $dishRepository): JsonResponse
    {
        $dish = $dishRepository->find($id);
        if (!$dish) {
            return $this->json(['message' => 'Dish not found'], 404);
        }
        $dishRepository->remove($dish, true);

        return $this->json(['message' => 'Dish deleted successfully']);
    }
}
