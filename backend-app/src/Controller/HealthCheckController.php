<?php

declare(strict_types=1);

namespace SustainabilityWorkshop\Controller;

class HealthCheckController
{
    public function index(): array
    {
        return [ 'time' => time() ];
    }
}
