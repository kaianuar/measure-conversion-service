<?php

namespace App\Services;

interface MeasurementInterface
{
    public function total(string $outputType, array $measurements) : array;
}