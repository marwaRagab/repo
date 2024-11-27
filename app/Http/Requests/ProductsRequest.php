<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => ['required'],
            'mark_id' => ['required'],
            'class_id' => ['required'],
            'model' => ['required'],
            'price' => ['required','numeric'],
            'net_price' => ['required'],
            'img' => ['required'],
            'number_type' => ['required'],
            'number' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->failed()) {
                    $validator->errors()->add('method', $this->method())->add('nameModel', '#vertical-center-modal');
            }
        });
    }
}
