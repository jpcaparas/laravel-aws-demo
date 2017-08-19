<?php

namespace App\Http\Requests\Aws;

class RekognitionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image'
        ];
    }
}
