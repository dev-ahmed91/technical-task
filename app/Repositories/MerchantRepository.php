<?php

namespace App\Repositories;

use App\DTOs\MerchantDto;
use App\Models\Merchant;

class MerchantRepository
{
    /**
     * @param MerchantDto $dto
     * @return void
     */
    public function save(MerchantDto $dto)
    {
        $merchant =  Merchant::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => bcrypt($dto->getPassword())
        ]);

        $merchant->initializeStore();
    }
}
