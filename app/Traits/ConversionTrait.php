<?php

namespace App\Traits;

trait ConversionTrait
{
    public function convertUOM(string $fromUOM, string $toUOM, float $unit) : float
    {
        // Construct the constant value using the from and to UOM units
        // At the moment this will output either METERTOYARD or YARDTOMETER
        // But can easily support additional conversion types such as CMTOINCHES, LITRETOPINTS, POUNDTOKG etc
        $conversionRate = strtoupper($fromUOM) . 'TO' . strtoupper($toUOM);

        return (float) constant($conversionRate) * $unit;
    }
}