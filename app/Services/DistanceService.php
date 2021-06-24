<?php

namespace App\Services;

use App\Traits\ConversionTrait;
use \Illuminate\Support\Facades\Lang;

class DistanceService implements MeasurementInterface
{
    use ConversionTrait;

    protected $allowedUnits;

    public function __construct()
    {
        $this->allowedUnits = ['meter', 'yard'];
    }
    
    public function total(string $outputType, array $measurements) : array
    {
        $total = null;

        [$statusCode, $errorType] = $this->validateMeasurements($outputType, $measurements);

        if (!empty($errorType)) {
            return [$statusCode, $total, $errorType];
        }

        try {
            $total = 0;
            foreach ($measurements as $key => $value) {
                if ($value['uom'] !== $outputType) {
                    $value['unit'] = $this->convertUOM($value['uom'], $outputType, $value['unit']);
                }
                $total += $value['unit'];
            }
            $statusCode = 200;          
        } catch (\Throwable $th) {
            // This will catch any errors other than validation
            $msg = 'There has been an internal server error. The error reported is: ';
            $msg .= $th->getMessage();

            $statusCode = 500;
            $errorType = $msg;
        }

        return [$statusCode, $total, $errorType];

    }

    private function validateMeasurements($outputType, $measurements)
    {
        $statusCode = '';
        $errorType = '';

        if (count($measurements) < 2) {
            $statusCode = 400;
            $errorType = trans('messages.TWO_UNITS_MIN');
        }

        if (!in_array($outputType, $this->allowedUnits)) {
            $statusCode = 400;
            $errorType = trans('messages.INVALID_OUTPUTTYPE');
        }

        foreach ($measurements as $key => $value) {
            if (!in_array($value['uom'], $this->allowedUnits)) {
                $statusCode = 400;
                $errorType = trans('messages.INVALID_UOM');
                break;
            } else if (!is_numeric($value['unit'])) {
                $statusCode = 400;
                $errorType = trans('messages.INVALID_UNIT');                
            }
        }

        return [$statusCode, $errorType];
    }
}