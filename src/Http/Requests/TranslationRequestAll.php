<?php

namespace JoeDixon\Translation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JoeDixon\Translation\Language;

class TranslationRequestAll extends FormRequest
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

    public $value = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'key' => 'required',
        ];

        $languages = Language::get();
        foreach($languages as $i => $lang){
            $rules['value'.$i] = 'required';
        }

        return $rules;
    }

}
