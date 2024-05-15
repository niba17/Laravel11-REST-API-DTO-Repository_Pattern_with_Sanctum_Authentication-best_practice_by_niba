<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Contracts\RegisterRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\DataTransferObject\RegisterDTO;

class AuthController extends Controller
{
    public function __construct(private RegisterRepositoryInterface $repository, private JsonResponse $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function register(AuthRequest $request)
    {
        try {
            $result = $this->repository->create(RegisterDTO::apiRequest($request));

            return new $this->response(['data' => $result->original], $result->getStatusCode());
        } catch (HttpException $exception) {
            return new $this->response(['error' => $exception->getMessage()], $exception->getStatusCode());
        }
    }

    public function login(AuthRequest $request)
    {
        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Username atau Password tidak sesuai!'
            ], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['data' => true], 200);
    }
}
