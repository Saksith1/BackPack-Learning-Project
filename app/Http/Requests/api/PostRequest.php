<?php

namespace App\Http\Requests\api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
          response()->json([

            'errors' => $validator->errors()->all(),

          ], 400)
        );
    }
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
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:trainers,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
