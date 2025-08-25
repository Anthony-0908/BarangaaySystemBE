<?php

namespace App\Trait;

trait ApiResponseTrait
{
    //

    public function successResponse($data =[], $message = 'Success' , $code = 200)
    {   
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($message = 'Error' , $code = 400, $errors = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,

        ],$code);
    }

    public function validationErrorResponse($errors, $message = 'Validation Failed')
    {
         return response()->json([
            'status' => 'fail',
            'message' => $message,
            'errors' => $errors,

        ],422);
    }
}
