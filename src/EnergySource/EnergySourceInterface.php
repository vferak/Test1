<?php

namespace Trayto\EnergySource;

interface EnergySourceInterface
{
    /**
     * Return current source energy.
     * @return int
     */
    public function getCurrentSourceAmount(): int;

    /**
     * Uses the source energy.
     */
    public function useEnergy(int $energyUsed): void;

    /**
     * Checks if the energy source is empty.
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Refills oil in the tank by a random amount between MIN and MAX volume of the tank.
     */
    public function refill(): void;
}