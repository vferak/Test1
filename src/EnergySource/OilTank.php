<?php

namespace Trayto\EnergySource;

use Trayto\CarException;


class OilTank implements EnergySourceInterface
{
    const MIN_TANK_VOLUME = 0;
    const MAX_TANK_VOLUME = 60;

    private int $currentOilInTank;

    public function __construct(int $oilInTank)
    {
        if ($oilInTank < self::MIN_TANK_VOLUME || $oilInTank > self::MAX_TANK_VOLUME) {
            throw new CarException("Amount of oil in tank in the initialization of the energy source is out of boundaries! Set it between " . self::MIN_TANK_VOLUME . " and " . self::MAX_TANK_VOLUME . ".");
        }

        $this->currentOilInTank = $oilInTank;
    }

    public function getCurrentSourceAmount(): int
    {
        return $this->currentOilInTank;
    }

    public function useEnergy(int $energyUsed): void
    {
        $this->currentOilInTank -= $energyUsed;
    }

    public function isEmpty(): bool
    {
        return $this->currentOilInTank == self::MIN_TANK_VOLUME;
    }

    public function refill(): void
    {
        $this->currentOilInTank = rand(self::MIN_TANK_VOLUME, self::MAX_TANK_VOLUME);
    }
}