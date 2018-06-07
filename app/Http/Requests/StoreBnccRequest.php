<?php

namespace C2Y\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBnccRequest extends FormRequest
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
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Você acabou esquecendo de preencher o campo descrição :o',
        ];
    }

}
