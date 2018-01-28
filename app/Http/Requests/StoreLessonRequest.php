<?php

namespace C2Y\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'name' => 'required',
            'link' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Er, você acabou esquecendo de colocar o nome da atividade :o',
            'link.required' => 'Por enquanto o link da atividade é obrigatório :('
        ];
    }
}
