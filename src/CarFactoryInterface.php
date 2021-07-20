<?php

namespace Trayto;


interface CarFactoryInterface
{
    public static function create(int $amountOfEnergy = 0): Car;
}