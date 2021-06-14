<?php

namespace App\Http\Controllers;

use App\Classes\DistanceClass As Distance;
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
        $error = $this->validateRequest($request->all());

        if ($error) {
            $data = [
                'error' => $error
            ];
    
            return self::returnJSON($data, 400);
        }

        $outputType = $request->input('outputType');
        $measurementData = $request->input('data');
        $total = $this->measurement->total($outputType, $measurementData);

        $data = [
            'uom' => $outputType,
            'total' => $total,
        ];

        return self::returnJSON($data);
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
                'outputType.in' => ':attribute needs to be either in yard or in meter',
                'data.size' => 'There must be exactly 2 units to calculate the total distance',
                'data.*.unit.numeric' => 'The unit field should be a numerical value',
                'data.*.uom.in' => 'The uom field needs to be either in yard or in meter'
            ]
        );

        if ($validate->stopOnFirstFailure()->fails()) {
            return $validate->errors()->first();
        }
    }
}