<?php

namespace App\Repositories;

use App\DTOs\UpdateStoreDto;
use App\Models\Store;

class StoreRepository
{
    /**
     * @param UpdateStoreDto $dto
     * @return void
     */
    public function update(UpdateStoreDto $dto): void
    {
        Store::where('merchant_id', $dto->getMerchantId())->update($dto->getData());
    }
}
