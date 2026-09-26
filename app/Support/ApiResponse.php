<?php

namespace App\Support;

class ApiResponse
{
  public static function success(mixed $data = null, string $message = 'Success', int $code = 200) { 
    return response()->json([
        'status' => 'success',
        'message' => $message,
        'data' => $data,
    ],$code);
  }

  public static function error(string $message = 'Error', int $code = 400 , mixed $errors = null) { 
    return response()->json([
        'status' => 'error',
        'message' => $message,
        'errors' => $errors,
    ],$code);   
  }
}
