<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator, // <--- O validador está aqui!
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }


    public function createUser(UserDTO $dto): User
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new BadRequestException((string) $errors);
        }


        $user = new User();
        $user->setEmail($dto->email);
        $user->setRoles($dto->roles);


        $hashedPassword = $this->passwordHasher->hashPassword($user, $dto->password);
        $user->setPassword($hashedPassword);
        $user->setPassword($hashedPassword);

        try {
            $this->userRepository->save($user, true);
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictHttpException('This email is already registered.');
        }

        return $user;
    }


    public function updateUser(int $id, UserDTO $dto): User
    {

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            throw new BadRequestException((string) $errors);
        }


        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }


        $user->setEmail($dto->email);


        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $dto->password
        );
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user, true);

        return $user;
    }

    public function getUserById(int $id): array
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];
    }

    public function getAllUsers(): array
    {
        $users = $this->userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ];
        }
        return $data;
    }


    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $this->userRepository->remove($user, true);
    }
}
