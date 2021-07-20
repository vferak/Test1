<?php

namespace Trayto;


class HybridCarFactory implements CarFactoryInterface
{
    /**
     * @throws CarException
     */
    public static function create(int $amountOfEnergy = 0): Car
    {
        $compositeEnergySource = new EnergySource\EnergySourceComposite();
        $compositeEnergySource->addSource(new EnergySource\OilTank($amountOfEnergy));
        $compositeEnergySource->addSource(new EnergySource\ElectricBattery($amountOfEnergy));

        return new Car($compositeEnergySource);
    }
}