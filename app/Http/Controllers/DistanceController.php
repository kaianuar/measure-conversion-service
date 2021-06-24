<?php

namespace App\Http\Controllers;

use App\Services\DistanceService As Distance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistanceController extends MeasurementAbstractController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Distance $measurement)
    {
        $this->measurement = $measurement;
        $this->allowedUnits = ['meter', 'yard'];
    }

    public function getTotal(Request $request)
    {
        try {
            $error = $this->validateRequest($request->all());

            if ($error) {
                $data = [
                    'error' => $error
                ];
        
                return self::returnJSON($data, 400);
            }
    
            $outputType = $request->input('outputType');
            $measurementData = $request->input('data');
            [$statusCode, $total] = $this->measurement->total($outputType, $measurementData);
    
            $data = [
                'uom' => $outputType,
                'total' => $total,
            ];
    
            return self::returnJSON($data);
        } catch (\Throwable $th) {
            // Catch any other exceptions
            $data = [
                'error' => 'There was a server error while processing the request'
            ];

            return self::returnJSON($data, 500);
        }

    }

    protected function validateRequest(array $request)
    {
        $validate = Validator::make(
            $request, 
            [
                'outputType' => [
                    'required',
                    'string',
                    Rule::in($this->allowedUnits),
                ],
                'data' => [
                    'array',
                    'size:2',
                    'required',
                ],
                'data.*.unit' => [
                    'required',
                    'numeric',
                ],
                'data.*.uom' => [
                    'required',
                    'string',
                    Rule::in($this->allowedUnits),
                ],
            ],
            [
                'outputType.in' => trans('messages.INVALID_OUTPUTTYPE'),
                'data.size' => trans('messages.TWO_UNITS_MIN'),
                'data.*.unit.numeric' => trans('messages.INVALID_UNIT'),
                'data.*.uom.in' => trans('messages.INVALID_UOM')
            ]
        );

        if ($validate->stopOnFirstFailure()->fails()) {
            return $validate->errors()->first();
        }
    }
}