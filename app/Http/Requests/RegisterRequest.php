<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Register request class
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:users|min:3|max:10',
            'email' => 'required|email|unique:users|min:6|max:50',
            'password' => 'required|string|min:6|max:10|same:confirmPassword'
        ];
    }

    /**
     * Failed Validation function
     *
     * @param Validator $validator
     * @return object
     */
    protected function failedValidation(Validator $validator)
    {
        // Format error validate
        $errors = (new ValidationException($validator))->errors();
        $errorValidate = [];
        foreach ($errors as $key => $error) {
            $errorValidate[$key] = $error[0];
        }

        throw new HttpResponseException(
            response()->json(
                [
                    'status' => config('constants.status.ERROR.BAD_REQUEST'),
                    'message' => config('constants.message.ERROR.BAD_REQUEST'),
                    'data' => $errorValidate
                ]
            )
        );
    }
}
