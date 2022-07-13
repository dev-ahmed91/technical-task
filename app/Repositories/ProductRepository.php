<?php

namespace App\Repositories;


use App\DTOs\ProductDto;
use App\Enums\TranslationType;
use App\Models\Product;
use App\Models\ProductTranslation;

class ProductRepository
{
    public function save(ProductDto $dto)
    {
        $product = Product::create([
            'store_id' => $dto->getStoreId()
        ]);

        ProductTranslation::create([
                'text' => $dto->getArName(),
                'type' => TranslationType::$NAME,
                'locale' => 'ar',
                'product_id' => $product->id,
            ]);

        ProductTranslation::create([
            'text' => $dto->getEnName(),
            'type' => TranslationType::$NAME,
            'locale' => 'en',
            'product_id' => $product->id,
        ]);

        ProductTranslation::create([
            'text' => $dto->getArDescription(),
            'type' => TranslationType::$DESCRIPTION,
            'locale' => 'ar',
            'product_id' => $product->id,
        ]);

        ProductTranslation::create([
            'text' => $dto->getEnDescription(),
            'type' => TranslationType::$DESCRIPTION,
            'locale' => 'en',
            'product_id' => $product->id,
        ]);
    }

    public function get(string $id)
    {
        return Product::find($id);
    }
}
