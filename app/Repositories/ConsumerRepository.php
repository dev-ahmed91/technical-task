<?php

namespace App\Repositories;


use App\DTOs\ConsumerDto;
use App\Models\Consumer;

class ConsumerRepository
{
    public function save(ConsumerDto $dto)
    {
        return Consumer::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => bcrypt($dto->getPassword())
        ]);
    }
}
