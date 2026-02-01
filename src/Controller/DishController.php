<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DishRepository; // <--- "App" e "Repository" com letra maiúscula
use App\Entity\Dish;

final class DishController extends AbstractController
{
    #[Route('/dish', name: 'list_dish', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DishController.php',
        ]);
    }

    #[Route('/dish', name: 'create_dish', methods: ['POST'])]
    public function create(Request $request, DishRepository $dishRepository): JsonResponse
    {
        $data = $request->request->all();

        $dish = new Dish();
        $dish->setName($data['name']);
        $dish->setDescription($data['description']);
        $dish->setPrice($data['price']);
        $dish->setCategory($data['category']);

        $dishRepository->add($dish, true);

        return $this->json([
                'message' => 'Dish created successfully'
        ],201);
    }
}
