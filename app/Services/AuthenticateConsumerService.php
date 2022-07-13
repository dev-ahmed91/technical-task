<?php

namespace App\Services;

use App\DTOs\ConsumerDto;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthenticateConsumerService
{
    /**
     * @throws Exception
     */
    public function login(ConsumerDto $dto): string
    {
        $token = auth()->guard('consumer')->attempt(['email' => $dto->getEmail(), 'password' => $dto->getPassword()]);

        if (!$token) {
            throw new Exception('Invalid Credentials', 401);
        }

        return $token;
    }

    public function logout(): void
    {
        Auth::guard('consumer')->logout();
    }
}
