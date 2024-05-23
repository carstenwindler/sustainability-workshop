<?php

namespace App\Http\Controllers;

class HealthCheckController
{
    public function index(): array
    {
        return [ 'time' => time() ];
    }
}
