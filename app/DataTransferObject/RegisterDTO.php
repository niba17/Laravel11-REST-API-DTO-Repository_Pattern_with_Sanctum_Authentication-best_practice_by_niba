<?php

namespace App\DataTransferObject;

class RegisterDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $password,
    ) {
    }

    public static function apiRequest($request): array
    {
        return [
            'name' => $request->name,
            'password' => $request->password,
        ];
    }
}
