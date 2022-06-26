<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser{ // to use this -> use ApiResponse and use App\Traits\ApiResponser


    /**
     * @param string|array: $data
     * @param int: $code
     * @return Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK){

        return response()->json(['data' => $data], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return
     */
    public function errorResponse($message, $code){
        // codigo en la respuesta como en el estado final de la respuesta
        return response()->json(['error' => $message, 'code' => $code]);
    }

}