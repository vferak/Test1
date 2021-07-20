<?php

use Trayto\CarException;

include "vendor/autoload.php";

$routeLength = 200;

try {
    $oilCar = \Trayto\OilCarFactory::create(50);
    $routeLog = $oilCar->go($routeLength);
    echo "OilCar:\n" . $routeLog;

    $electricCar = \Trayto\ElectricCarFactory::create(20);
    $routeLog = $electricCar->go($routeLength);
    echo "ElectricCar:\n" . $routeLog;

    $hybridCar = \Trayto\HybridCarFactory::create(30);
    $routeLog = $hybridCar->go($routeLength);
    echo "HybridCar:\n" . $routeLog;

    echo $routeLog;
} catch (CarException $exception) {
    echo $exception->getMessage();
}


