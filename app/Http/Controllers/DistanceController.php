<?php

namespace App\Http\Controllers;

use App\Classes\DistanceClass As Distance;
use Illuminate\Http\Request;

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
        $outputType = $request->input('outputType');
        $measurementData = $request->input('data');
        $total = $this->measurement->total($outputType, $measurementData);

        $data = [
            'uom' => $outputType,
            'total' => $total,
        ];

        return self::returnJSON($data);
    }
}