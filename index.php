<?php

include "Car.php";
include "CarException.php";

$currentOilInTank = 45;
$routeLength = 200;

try {
    $car = new Car($currentOilInTank);
    $routeLog = $car->go($routeLength);

    echo $routeLog;
} catch (CarException $exception) {
    echo $exception->getMessage();
}


