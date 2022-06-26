<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser{ // to use this -> use ApiResponse and use App\Traits\ApiResponser


    /**
     * Build a success response
     * @param string|array: $data
     * @param int: $code
     * @return Illuminate\Http\Response
     */
    public function successResponse($data, $code = Response::HTTP_OK){

        // the response is already prepared so we need to send it as it is, but we need to specify to the client that is gonna be a json with headers
        return response($data, $code)->header('Content-Type', 'application/json'); // json response from the json we already got in the successResponse data
    }

    /**
     * Build a valid response
     * @param string|array: $data
     * @param int: $code
     * @return Illuminate\Http\Response
     */
    public function validResponse($data, $code = Response::HTTP_OK){

        // the response is already prepared so we need to send it as it is, but we need to specify to the client that is gonna be a json with headers
        return response()->json(['data' => $data], $code);  
    }

    /** Internal http errors 
     * @param string $message
     * @param int $code
     * @return
     */
    public function errorResponse($message, $code){
        // codigo en la respuesta como en el estado final de la respuesta
        return response()->json(['error' => $message, 'code' => $code]);
    }

    /** This method send the same format error message like errorResponse method but this one is for messages from external services 
     * @param string $message
     * @param int $code
     * @return Illuminate\Http\Response
     */
    public function errorMessage($message, $code){
        // the response is already prepared so we need to send it as it is, but we need to specify to the client that is gonna be a json with headers
        return response($message, $code)->header('Content-Type', 'application/json'); // json response from the json we already got in the successResponse data
    }

}