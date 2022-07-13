<?php

namespace App\Http\Controllers;

use App\Mappers\ConsumerMapper;
use App\Repositories\ConsumerRepository;
use App\Services\AuthenticateConsumerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ConsumerController extends Controller
{
    private $authenticateService;

    private $repository;

    public function __construct(AuthenticateConsumerService $authenticateService,
                                ConsumerRepository $repository)
    {
        $this->authenticateService = $authenticateService;
        $this->repository = $repository;
    }

    /**
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 400);
        }

        try {
            $dto = ConsumerMapper::toDto($request);

            $token = $this->authenticateService->login($dto);

            return $this->respondWithToken($token);

        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function logout(): JsonResponse
    {
        $this->authenticateService->logout();

        return response()->json([
            'message' => "Logged out successfully"
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('merchant')->factory()->getTTL() * 60
        ]);
    }

    /**
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:merchants',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 401);
        }

        $dto = ConsumerMapper::toDto($request);

        $this->repository->save($dto);

        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }

    public function index(){
        dd("Mustafa");
    }
}
