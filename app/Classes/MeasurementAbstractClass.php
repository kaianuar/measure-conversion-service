<?php

namespace App\Classes;

abstract class MeasurementAbstractClass implements MeasurementInterface
{
    abstract public function total(string $outputType, array $measurements) : float;
}