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

        return $measurementData;
    }

    /**
     * @depends testMeterConvertedToYard
     */
    public function testYardConvertedToMeter(array $data)
    {

        $measurementData = $data;
        $outputType = 'yard';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);

        $this->assertEquals($total, 8.46805);
    }

    /**
     * @depends testMeterConvertedToYard
     */
    public function testExceptionIfInvalidOutputType(array $data)
    {
        $this->expectException(InvalidArgumentException::class);
        $measurementData = $data;
        $outputType = 'inches';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);
    }

    public function testExceptionIfMeasurementDataIsLessThanTwo()
    {
        $this->expectException(InvalidArgumentException::class);
        $measurementData = [
            0 => [
                'unit' => 5,
                'uom' => 'meter'
            ]
        ];
        $outputType = 'yard';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);
    }

    public function testExceptionIfMeasurementDataHasInvalidUOM()
    {
        $this->expectException(InvalidArgumentException::class);
        $measurementData = [
            0 => [
                'unit' => 5,
                'uom' => 'inches'
            ],
            1 => [
                'unit' => 3,
                'uom' => 'yard',
            ]
        ];
        $outputType = 'yard';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);
    }

    public function testExceptionIfMeasurementUnitIsNotAvalidNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        $measurementData = [
            0 => [
                'unit' => "abc",
                'uom' => 'yard'
            ],
            1 => [
                'unit' => 3,
                'uom' => 'yard',
            ]
        ];
        $outputType = 'yard';
        
        $measurement = new Distance();
        $total = $measurement->total($outputType, $measurementData);
    }
}