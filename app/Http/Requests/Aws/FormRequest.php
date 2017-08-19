<?php

namespace App\Http\Requests\Aws;

use Illuminate\Foundation\Http\FormRequest as FormRequestBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FormRequest extends FormRequestBase
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
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
