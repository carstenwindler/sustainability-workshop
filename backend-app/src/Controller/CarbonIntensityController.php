<?php

declare(strict_types=1);

namespace SustainabilityWorkshop\Controller;

use GreenElephpant\CarbonAware\Service\CarbonAwareService;

class CarbonIntensityController
{
    public function __construct(
        private CarbonAwareService $carbonAwareService
    ) {
    }

    public function current(): array
    {
        $current = $this->carbonAwareService->getCurrent();
        $isGreen = true;

        if ($current->isLow()) {
            $isGreen = false;
        }

        return [
            'is_green' => $isGreen
        ];
    }
}
