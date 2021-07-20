<?php

namespace Trayto;


class ElectricCarFactory implements CarFactoryInterface
{
    /**
     * @throws CarException
     */
    public static function create(int $amountOfEnergy = 0): Car
    {
        $energySource = new EnergySource\ElectricBattery($amountOfEnergy);
        return new Car($energySource);
    }
}