<?php

namespace App\Http\Controllers\Aws;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Response;

/**
 * Class Controller
 *
 * @package App\Http\Controllers\Aws
 */
class Controller extends BaseController
{
    /**
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendErrors(array $data)
    {
        return $this->sendResponse(['errors' => $data], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param array $data
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(array $data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
