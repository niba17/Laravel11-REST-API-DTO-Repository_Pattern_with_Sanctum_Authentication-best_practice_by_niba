<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'username' => 'required|max:255|unique:users',
                    'passsword' => 'required|max:255',
                ];
            case 'PUT':
                $user_uuid = $this->route('user');

                return [
                    'username' => 'required|max:225|unique:users,username,' . $user_uuid . ',uuid',
                    'passsword' => 'required|max:255',
                ];
            default:
                break;
        }
    }

    public function messages()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'username.required' => 'Username harus diisi!',
                    'username.max' => 'Maksimal karakter Username adalah :max karakter!',
                    'username.unique' => 'Username sudah ada!',

                    'password.required' => 'Password harus diisi!',
                    'password.max' => 'Maksimal karakter Password adalah :max karakter!',
                ];
            case 'PUT':
                return [
                    'username.required' => 'Username harus diisi!',
                    'username.max' => 'Maksimal karakter Username adalah :max karakter!',
                    'username.unique' => 'Username sudah ada!',

                    'password.required' => 'Password harus diisi!',
                    'password.max' => 'Maksimal karakter Password adalah :max karakter!',
                ];
            default:
                break;

        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            response()->json([
                'error' => $validator->errors(),
            ], status: Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
