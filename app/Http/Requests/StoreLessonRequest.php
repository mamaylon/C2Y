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
            'model' => 'required',
            'owner' => 'required',
            'owners' => 'required_if:owner,"false"',
            'bncc_components' => 'required_without:pc_components',
            'description' => 'required',
            'goals' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Hmm, você acabou esquecendo de colocar o nome da atividade.',
            'model.required' => 'Hey o modelo da atividade é obrigatório!',
            'owner.required' => 'É necessario informar se você é o autor',
            'owners.required_if' => 'Como você não é o criador, é preciso dizer quem é',
            'bncc_components.required_without' => 'É necessario escolher pelo menos um componente do Pensamento computacional OU da BNCC',
            'description.required' => 'Sinto muito mas é necessario preencher a descrição.',
            'goals.required' => 'Sejamos objetivos, os objetivos são necessarios!'
        ];
    }
}
