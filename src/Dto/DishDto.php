<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class DishDto
{
    #[Assert\Length(min: 3, minMessage: "O nome tá muito curto, use pelo menos 3 letras.")]
    public string $name;

    #[Assert\NotBlank(message: "A descrição é obrigatória.")]
    public string $description;

    #[Assert\NotBlank]
    #[Assert\Positive(message: "O preço precisa ser maior que zero.")]
    public float $price;

    #[Assert\NotBlank]
    public string $category;

    public static function DtoValidation(array $data): self
    {
        $dto = new self();
        $dto->name = $data['name'];
        $dto->description = $data['description'];
        $dto->price = isset($data['price']) ? (float)$data['price'] : 0;
        $dto->category = $data['category'];
        
        return $dto;
    }
}