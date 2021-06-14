<?php

namespace App\Classes;

class DistanceClass extends MeasurementAbstractClass
{
    public function total(string $outputType, array $measurements) : float
    {
        $total = 0;
        foreach ($measurements as $key => $value) {
            if ($value['uom'] !== $outputType) {
                $value['unit'] = $this->convertUOM($value['uom'], $outputType, $value['unit']);
            }
            $total += $value['unit'];
        }
        return $total;
    }
}