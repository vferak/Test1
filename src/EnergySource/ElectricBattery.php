<?php

namespace Trayto\EnergySource;

use Trayto\CarException;


class ElectricBattery implements EnergySourceInterface
{
    const MIN_BATTERY_CHARGE = 0;
    const MAX_BATTERY_CHARGE = 30;

    private int $currentBatteryCharge;

    public function __construct(int $batteryCharge)
    {
        if ($batteryCharge < self::MIN_BATTERY_CHARGE || $batteryCharge > self::MAX_BATTERY_CHARGE) {
            throw new CarException("Amount of battery charge in the initialization of the energy source is out of boundaries! Set it between " . self::MIN_BATTERY_CHARGE . " and " . self::MAX_BATTERY_CHARGE . ".");
        }

        $this->currentBatteryCharge = $batteryCharge;
    }

    public function getCurrentSourceAmount(): int
    {
        return $this->currentBatteryCharge;
    }

    public function useEnergy(int $energyUsed): void
    {
        $this->currentBatteryCharge -= $energyUsed;
    }

    public function isEmpty(): bool
    {
        return $this->currentBatteryCharge == self::MIN_BATTERY_CHARGE;
    }

    public function refill(): void
    {
        $this->currentBatteryCharge = rand(self::MIN_BATTERY_CHARGE, self::MAX_BATTERY_CHARGE);
    }
}