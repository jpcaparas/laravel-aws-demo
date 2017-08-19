<?php

namespace App\Http\Requests\Aws;

class S3UploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_name' => 'required:max:100',
            'file' => 'required|file'
        ];
    }
}
