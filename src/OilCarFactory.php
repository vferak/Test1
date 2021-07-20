<?php

namespace Trayto;


class OilCarFactory implements CarFactoryInterface
{
    /**
     * @throws CarException
     */
    public static function create(int $amountOfEnergy = 0): Car
    {
        $energySource = new EnergySource\OilTank($amountOfEnergy);
        return new Car($energySource);
    }
}