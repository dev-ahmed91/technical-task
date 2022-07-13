<?php

namespace App\Repositories;

use App\DTOs\AddProductToCartDto;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class CartRepository
{
    public function add(AddProductToCartDto $dto)
    {
        Cart::create([
            'consumer_id' => $dto->getConsumerId(),
            'product_id' => $dto->getProduct()->id,
            'quantity' => $dto->getQuantity()
        ]);

        $cart =  json_decode(Redis::get('cart_' .$dto->getConsumerId()), true);

        $product = $dto->getProduct();
       if($cart) {
           if (!isset($cart['products'][$product->id])) {
               $cart['products'][$product->id] = [
                   'product_id' => $product->id,
                   'product_name' => $product->getName(app()->getLocale()),
                   'product_description' => $product->getDescription(app()->getLocale()),
                   'qty' => $dto->getQuantity()
               ];

           } else {
               $cart['products'][$product->id]['qty'] += 1;
           }

       } else {
           $cart = ['total' => 0];

           $cart['products'][$product->id] = [
               'product_id' => $product->id,
               'product_name' => $product->getName(app()->getLocale()),
               'product_description' => $product->getDescription(app()->getLocale()),
               'qty' => $dto->getQuantity()
           ];
       }

        $cart['total'] += $this->calculateProductPrice($product) + $product->store->shipping_cost;

        Redis::set('cart_' .$dto->getConsumerId(), json_encode($cart));
    }

    private function calculateProductPrice(Product $product)
    {
        $vat = $product->store->price_include_vat ? ($product->store->vat_value/100) : 0;
        $vat = $vat * $product->price;
        return $product->price + $vat;
    }
}
