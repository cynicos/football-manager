<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChampionshipRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->segment('3') ?? 0;

        $rules = [
            'name' => 'required|string|unique:championships,name,' . $id,
        ];

        if(!$id || $this->hasFile('logo')){
            $rules['logo'] = 'required|image|mimes:jpg,png';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge(decodedRequest($this->all()));
    }

    protected function failedValidation(Validator $validator)
    {
        response()->json($validator->errors(), 422)->throwResponse();
    }
}
