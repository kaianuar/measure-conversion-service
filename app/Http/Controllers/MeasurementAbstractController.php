<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

abstract class MeasurementAbstractController extends Controller
{
    protected $measurement;

    protected $allowedUnits;

    public abstract function getTotal(Request $request);
}