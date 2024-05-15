<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface RegisterRepositoryInterface
{
    public function create(array $request): JsonResponse;
    // public function show(string $uuid): JsonResponse;
    // public function save(array $request): JsonResponse;
    // public function update(array $request, string $uuid): JsonResponse;
    // public function delete(string $uuid): JsonResponse;
}
