<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * PostRequest class
 */
class PostRequest extends FormRequest
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
            'title' => 'required|string|min:4|max:30',
            'body' => 'required|string|min: 10|max:50'
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
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                    'status' => config('constants.status.ERROR.BAD_REQUEST'),
                    'message' => config('constants.message.ERROR.BAD_REQUEST'),
                    'data' => $errors
                ]
            )
        );
    }
}
