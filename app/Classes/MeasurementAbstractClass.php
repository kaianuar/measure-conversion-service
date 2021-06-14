<?php

namespace App\Classes;

use App\Traits\ConversionTrait;

abstract class MeasurementAbstractClass implements MeasurementInterface
{
    use ConversionTrait;

    abstract public function total(string $outputType, array $measurements) : float;
}