<?php

namespace Trayto\EnergySource;

use Trayto\CarException;


class EnergySourceComposite implements EnergySourceInterface
{
    /** @var EnergySourceInterface[] */
    private array $energySources;

    public function __construct()
    {
        $this->energySources = [];
    }

    /**
     * The order in which are the sources added matters!
     * @throws CarException
     */
    public function addSource(EnergySourceInterface $energySource): void
    {
        foreach ($this->energySources as $energySrc) {
            if ($energySource instanceof $energySrc) {
                throw new CarException("Trying to add already existing energy source to composite!");
            }
        }

        $this->energySources[] = $energySource;
    }

    /**
     * Return the current energy of first, not empty source.
     * @return int
     */
    public function getCurrentSourceAmount(): int
    {
        foreach ($this->energySources as $energySource) {
            if (!$energySource->isEmpty()) {
                return $energySource->getCurrentSourceAmount();
            }
        }

        return 0;
    }

    /**
     * Uses the current energy of first, not empty source.
     */
    public function useEnergy(int $energyUsed): void
    {
        foreach ($this->energySources as $energySource) {
            if (!$energySource->isEmpty()) {
                $energySource->useEnergy($energyUsed);
                return;
            }
        }
    }

    /**
     * Return true if all sources are empty, false otherwise.
     * @return bool
     */
    public function isEmpty(): bool
    {
        foreach ($this->energySources as $energySource) {
            if (!$energySource->isEmpty()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Refills all sources.
     */
    public function refill(): void
    {
        foreach ($this->energySources as $energySource) {
            $energySource->refill();
        }
    }
}