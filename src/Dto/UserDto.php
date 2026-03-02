<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\NotBlank(message: "O email é obrigatório.")]
        #[Assert\Email(message: "O email informado não é válido.")]
        public readonly string $email,
        #[Assert\NotBlank(message: "A senha é obrigatória.")]
        #[Assert\Length(min: 8, minMessage: "A senha deve ter pelo menos 8 caracteres.")]
        #[Assert\Regex(
            pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            message: "A senha deve conter pelo menos: uma letra maiúscula, uma minúscula, um número e um caractere especial."
        )]
        public readonly string $password,
        #[Assert\Type('array')]
        public readonly array $roles = ['ROLE_USER']
    ) {
    }
}
