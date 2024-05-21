<?php

namespace SustainabilityWorkshop;

use Buzz\Client\Curl;
use GreenElephpant\CarbonAware\Location\Location;
use GreenElephpant\CarbonAware\DataProvider\ElectricityMaps\Connector\ElectricityMapsConnector;
use GreenElephpant\CarbonAware\DataProvider\ElectricityMaps\ElectricityMaps;
use GreenElephpant\CarbonAware\DataProvider\EnergyCharts\Connector\EnergyChartsConnector;
use GreenElephpant\CarbonAware\DataProvider\EnergyCharts\EnergyCharts;
use GreenElephpant\CarbonAware\Service\CarbonAwareService;
use Nyholm\Psr7\Factory\Psr17Factory;

class CarbonAwareFactory
{
    public static function create(
        string $type,
        string $locationTwoLetterCode,
        AbstractCachePool $pool = null
    ) {
        $psr17Factory = new Psr17Factory();
        $psr18Client = new Curl($psr17Factory);
        $location = new Location($locationTwoLetterCode);

        switch ($type) {
            case EnergyCharts::class:
                $energyChartsConnector = new EnergyChartsConnector(
                    $psr18Client,
                    $psr17Factory,
                );

                $dataProvider = new EnergyCharts(
                    $location,
                    $energyChartsConnector
                );
                break;

            case ElectricityMaps::class:
                $electricityMapsConnector = new ElectricityMapsConnector(
                    $psr18Client,
                    $psr17Factory,
                    'api-key'
                );

                $dataProvider = new ElectricityMaps(
                    new Location($locationTwoLetterCode),
                    $electricityMapsConnector
                );
                break;

            default:
                throw new \InvalidArgumentException('Invalid type');
        }

        return new CarbonAwareService($dataProvider, $location);
    }

}
