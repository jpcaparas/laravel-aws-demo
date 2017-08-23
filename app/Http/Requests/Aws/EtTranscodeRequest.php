<?php

namespace App\Http\Requests\Aws;

class EtTranscodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|max:100',
            'file' => 'required|file|mimetypes:video/mp4,',
        ];
    }
}
