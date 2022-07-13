<?php

namespace App\Services;

use App\DTOs\MerchantDto;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthenticateMerchantService
{
    /**
     * @throws Exception
     */
    public function login(MerchantDto $dto): string
    {
        $token = auth()->guard('merchant')->attempt(['email' => $dto->getEmail(), 'password' => $dto->getPassword()]);

        if (!$token) {
            throw new Exception('Invalid Credentials', 401);
        }

        return $token;
    }

    public function logout(): void
    {
        Auth::guard('merchant')->logout();
    }
}
