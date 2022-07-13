<?php

namespace App\Http\Controllers;

use App\DTOs\AddProductToCartDto;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    private $repository;
    private $productRepository;

    public function __construct(CartRepository $repository, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    public function addTo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id'   => 'required',
            'quantity' => 'required|min:1'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 400);
        }

        try {
            $product = $this->productRepository->get($request->product_id);
            $dto = new AddProductToCartDto();
            $dto->setConsumerId(auth()->user()->id);
            $dto->setProduct($product);
            $dto->setQuantity($request->quantity);

            $this->repository->add($dto);

            return response()->json(['message' => 'added to cart successfully']);

        } catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

}
