<?php

namespace App\Http\Controllers;

use App\DTOs\UpdateStoreDto;
use App\Repositories\StoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    private $repository;

    public function __construct(StoreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vat_value'   => 'required_if:price_include_vat,true',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 400);
        }

        try {

            $dto = new UpdateStoreDto();
            $dto->setMerchantId(auth()->user()->id);
            $dto->setData($request->only(['name', 'price_include_vat', 'vat_value', 'shipping_cost']));

            $this->repository->update($dto);

        } catch (\Exception $exception){
            return response()->json(["message" => "Error while updating store:{$exception->getMessage()}"], 500);
        }

        return response()->json(["message" => "Store updated successfully"], 200);

    }
}
