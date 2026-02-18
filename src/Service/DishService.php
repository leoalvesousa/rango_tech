<?php

namespace App\Service;

use App\Entity\Dish;
use App\Repository\DishRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Dto\DishDto;

class DishService
{
    public function __construct(
        private DishRepository $dishRepository,
        private ValidatorInterface $validator
    ) {}

    public function createDish(DishDTO $dto): Dish
    {
        $dish = new Dish();
  
        $dish->setName($dto->name);
        $dish->setDescription($dto->description);
        $dish->setPrice((string)$dto->price);
        $dish->setCategory($dto->category);

        $this->dishRepository->add($dish, true);

        return $dish;
    }

    public function getAllDishes(): array
    {
        $dishes = $this->dishRepository->findBy([], ['id' => 'ASC']);
        
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
        return $data;
    }

    public function getDishById(int $id): ?array
{

    $dish = $this->dishRepository->find($id);

    if (!$dish) {
        throw new NotFoundHttpException('Dish not found');
    }

    return [
        'id' => $dish->getId(),
        'name' => $dish->getName(),
        'description' => $dish->getDescription(),
        'price' => $dish->getPrice(),
        'category' => $dish->getCategory(),
    ];
}

    public function updateDish(int $id, array $data): ?Dish
    {
        $dto = DishDto::DtoValidation($data);

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new BadRequestHttpException((string) $errors);
        }
        
        $dish = $this->dishRepository->find($id);

        if (!$dish) {
            throw new NotFoundHttpException('Dish not found');
        }

        if (isset($data['name'])) { $dish->setName($data['name']); }
        if (isset($data['description'])) { $dish->setDescription($data['description']); }
        if (isset($data['price'])) { $dish->setPrice($data['price']); }
        if (isset($data['category'])) { $dish->setCategory($data['category']); }

        $this->dishRepository->add($dish, true);

        return $dish;
    }
    
    public function deleteDish(int $id): bool
    {
        $dish = $this->dishRepository->find($id);
        if (!$dish) {
            throw new NotFoundHttpException('Dish not found');
        }
        
        $this->dishRepository->remove($dish, true);
        return true;
    }
}