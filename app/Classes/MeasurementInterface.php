<?php

namespace App\Classes;

interface MeasurementInterface
{
    public function total(string $outputType, array $measurements) : float;
}