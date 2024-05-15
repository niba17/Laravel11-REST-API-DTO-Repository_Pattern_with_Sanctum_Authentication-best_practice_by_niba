<?php

namespace App\Repositories;

use App\Models\user;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RegisterResource;
use App\Contracts\RegisterRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterRepository implements RegisterRepositoryInterface
{

    public function __construct(private user $user, private JsonResponse $response)
    {
        $this->user = $user;
        $this->response = $response;
    }

    public function create($request): JsonResponse
    {
        try {
            $user = $this->user->create($request);

            $resource = new RegisterResource($user);

            return new $this->response($resource, $this->response::HTTP_CREATED);
        } catch (\Throwable $e) {
            throw new HttpException($this->response::HTTP_INTERNAL_SERVER_ERROR, 'Error server internal');
        }

    }
}
