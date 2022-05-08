<?php

namespace App\Service\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserManager extends AbstractManager
{
    #[Pure]
    public function __construct(
        protected Security $security,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $hasher,
    ) {
        parent::__construct($security);
    }

    public function createOneFromRequest(Request $request): array | User
    {
        $parameters = self::getParametersFromRequest($request);

        $firstName = $parameters['firstName'] ?? null;
        $lastName = $parameters['lastName'] ?? null;
        $birthDateString = $parameters['birthDate'] ?? null;
        $email = $parameters['email'] ?? null;
        $password = $parameters['password'] ?? null;

        if (!($firstName && $lastName && $birthDateString && $email && $password)) {
            return [ 'error' => 'Missing parameters' ];
        }

        try {
            $birthDate = new \DateTime($birthDateString);
        } catch (\Exception $e) {
            return [ 'error' => 'Invalid birthdate.' ];
        }

        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            return [ 'error' => 'Invalid email' ];
        }

        if ($this->userRepository->findOneBy([ 'email' => $email ])) {
            return [ 'error' => 'An account already exists with this email address.' ];
        }

        $user = (new User())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setBirthDate($birthDate)
            ->setEmail($email)
            ->setUsername($email);

        $this->userRepository->upgradePassword($user, $this->hasher->hashPassword($user, $password));
        $this->userRepository->add($user, true);

        return $user;
    }
}
