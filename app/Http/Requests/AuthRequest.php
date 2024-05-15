<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->route()->getName()) {
            case 'register':
                return [
                    'name' => 'required|unique:users|max:255',
                    'password' => 'required|max:255',
                    'c_password' => 'required|max:255|same:password',
                ];
            case 'login':
                return [
                    'name' => 'required',
                    'password' => 'required',
                ];
            default:
                return [];
        }
    }

    public function messages(): array
    {
        switch ($this->route()->getName()) {
            case 'register':
                return [
                    'name.required' => 'Username wajib diisi!',
                    'name.unique' => 'Username sudah ada!',
                    'name.max' => 'Batas karakter Username adalah :max!',

                    'password.required' => 'Password wajib diisi!',
                    'password.max' => 'Batas karakter Password adalah :max!',

                    'c_password.required' => 'Konfirmasi Password wajib diisi!',
                    'c_password.max' => 'Batas karakter Password adalah :max!',
                    'c_password.same' => 'Konfirmasi Password tidak sesuai!',
                ];
            case 'login':
                return [
                    'name.required' => 'Username wajib diisi!',

                    'password.required' => 'Password wajib diisi!',
                ];
            default:
                return [];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}

