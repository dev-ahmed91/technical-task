<?php

namespace App\Mappers;

use App\DTOs\MerchantDto;
use Illuminate\Http\Request;

class MerchantMapper
{
    public static function toDto(Request $request): MerchantDto
    {
        $dto = new MerchantDto();
        $dto->setName($request->name);
        $dto->setEmail($request->email);
        $dto->setPassword($request->password);

        return $dto;
    }
}
