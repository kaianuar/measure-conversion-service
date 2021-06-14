<?php

use App\Classes\DistanceClass as Distance;

class DistanceClassTest extends TestCase
{
    public function testMeterConvertedToYard()
    {
        $measurementData = [
            0 => [
                'unit' => 5,
                'uom' => 'meter'
            ],
            1 => [
                'unit' => 3,
                'uom' => 'yard',
            ]
        ];
        $outputType = 'meter';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);

        $this->assertEquals($total, 7.7432);
    }

    public function testYardConvertedToMeter()
    {
        $measurementData = [
            0 => [
                'unit' => 5,
                'uom' => 'meter'
            ],
            1 => [
                'unit' => 3,
                'uom' => 'yard',
            ]
        ];
        $outputType = 'yard';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);

        $this->assertEquals($total, 8.46805);
    }
}