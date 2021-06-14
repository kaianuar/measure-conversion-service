<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function returnJSON(array $data, $responseCode = 200)
    {
        return response()
            ->json(
                [
                    'status' => $responseCode,
                    'data' => $data,
                ], 
                $responseCode, 
                [
                    'Content-Type' => 'application/json'
                ]
            );
    }
}
