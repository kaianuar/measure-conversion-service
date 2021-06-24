<?php

use App\Services\DistanceService as Distance;

class DistanceServiceTest extends TestCase
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
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($total, 7.7432);
        $this->assertEquals($statusCode, 200);
        $this->assertEmpty($errorType);

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
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($total, 8.46805);
        $this->assertEquals($statusCode, 200);
        $this->assertEmpty($errorType);
    }

    /**
     * @depends testMeterConvertedToYard
     */
    public function testExceptionIfInvalidOutputType(array $data)
    {
        $measurementData = $data;
        $outputType = 'inches';
        
        $measurement = new Distance();
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($statusCode, 400);
        $this->assertEquals($errorType, 'The outputType needs to be either in yard or in meter');
        $this->assertNull($total);
    }

    public function testExceptionIfMeasurementDataIsLessThanTwo()
    {
        $measurementData = [
            0 => [
                'unit' => 5,
                'uom' => 'meter'
            ]
        ];
        $outputType = 'yard';
        
        $measurement = new Distance();
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($statusCode, 400);
        $this->assertEquals($errorType, '2 units of measurements needed to perform the calculation.');
        $this->assertNull($total);
    }

    public function testExceptionIfMeasurementDataHasInvalidUOM()
    {
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
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($statusCode, 400);
        $this->assertEquals($errorType, 'The uom field needs to be either in yard or in meter');
        $this->assertNull($total);
    }

    public function testExceptionIfMeasurementUnitIsNotAvalidNumber()
    {
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
        [$statusCode, $total, $errorType] = $measurement->total($outputType, $measurementData);

        $this->assertEquals($statusCode, 400);
        $this->assertEquals($errorType, 'The unit field should be a numerical value');
        $this->assertNull($total);
    }
}