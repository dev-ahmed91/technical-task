<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDto;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name_ar'   => 'required',
            'name_en'   => 'required',
            'description_ar'   => 'required',
            'description_en'   => 'required',
            'price' => 'required:double'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 400);
        }

        try {
            $data = $request->all();

            $dto = new ProductDto();
            $dto->setStoreId(auth()->user()->store->id);
            $dto->setArName($data['name_ar']);
            $dto->setEnName($data['name_en']);
            $dto->setArDescription($data['description_ar']);
            $dto->setEnDescription($data['description_en']);
            $dto->setPrice($data['price']);

            $this->repository->save($dto);

        } catch (\Exception $exception){
            return response()->json(["message" => "Error while adding the product:{$exception->getMessage()}"], 500);
        }

        return response()->json(["message" => "Product Added successfully"], 200);

    }
}
