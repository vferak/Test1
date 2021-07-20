<?php

namespace Trayto;

use Trayto\EnergySource\EnergySourceInterface;

class Car
{
    const MIN_TANK_VOLUME = 0;
    const MAX_TANK_VOLUME = 60;

    const MIN_SPEED = 0;
    const MAX_SPEED = 5;

    const STARTING_DISTANCE = 0;

    private int $currentSpeed;

    private EnergySourceInterface $energySource;

    private int $distanceDriven;

    /**
     * Car constructor.
     * @param EnergySourceInterface $energySource Energy source for the car.
     */
    public function __construct(EnergySourceInterface $energySource)
    {
        $this->energySource = $energySource;

        $this->currentSpeed = self::MIN_SPEED;
        $this->distanceDriven = self::STARTING_DISTANCE;
    }

    /**
     * Makes the car move.
     * @param int $distance Sets the length of the route in kilometers.
     * @return string Log of the route.
     * @throws CarException
     */
    public function go(int $distance): string
    {
        if ($distance < 0) {
            throw new CarException("Can't go backwards! Set the route distance to positive number.");
        }

        $currentlyDriven = 0;

        $routeLog = $this->logCurrentState();

        while ($currentlyDriven < $distance) {
            if ($this->energySource->isEmpty()) {
                $this->stop();
                $this->energySource->refill();
                $routeLog .= $this->logEnergyRefill();
            }

            $this->addSpeed();

            $distanceLeft = $distance - $currentlyDriven;
            if ($distanceLeft < $this->currentSpeed) {
                $this->setSpeed($distanceLeft);
            }

            $distanceTraveled = $this->goInSpeed();

            $currentlyDriven += $distanceTraveled;
            $this->distanceDriven += $distanceTraveled;

            $routeLog .= $this->logCurrentState();
        }

        return $routeLog;
    }

    /**
     * Adds to current speed.
     */
    private function addSpeed(): void
    {
        if ($this->currentSpeed < self::MAX_SPEED) {
            $this->currentSpeed++;
        }
    }

    /**
     * Subtracts from current speed. Currently not in use...
     */
    private function subSpeed(): void
    {
        if ($this->currentSpeed > self::MIN_SPEED) {
            $this->currentSpeed--;
        }
    }

    /**
     * Sets the currentSpeed to specified amount.
     * @param int $speed
     */
    private function setSpeed(int $speed): void
    {
        if ($speed < self::MIN_SPEED) {
            $this->currentSpeed = self::MIN_SPEED;
        } elseif ($speed > self::MAX_SPEED) {
            $this->currentSpeed = self::MAX_SPEED;
        } else {
            $this->currentSpeed = $speed;
        }
    }

    /**
     * Stops the car.
     */
    private function stop(): void
    {
        $this->currentSpeed = self::MIN_SPEED;
    }

    /**
     * Uses energy based on currentSpeed. If currentSpeed is higher than currentEnergyAmount, sets the speed to use the rest of the energy.
     */
    private function useEnergy(): void
    {
        $currentSourceAmount = $this->energySource->getCurrentSourceAmount();
        if ($currentSourceAmount < $this->currentSpeed) {
            $this->setSpeed($currentSourceAmount);
        }

        $this->energySource->useEnergy($this->currentSpeed);
    }

    /**
     * Tries to go forward in current speed.
     * @return int
     */
    private function goInSpeed(): int
    {
        if ($this->currentSpeed <= self::MIN_SPEED) {
            return 0;
        }

        $this->useEnergy();
        return $this->currentSpeed;
    }

    /**
     * Returns currents state of the car.
     * @return string
     */
    private function logCurrentState(): string
    {
        return "Car currently traveled for " . $this->distanceDriven . " km, has " . $this->energySource->getCurrentSourceAmount() . " amount of energy and went in speed " . $this->currentSpeed . ".\n";
    }

    /**
     * Returns information about energy refill.
     * @return string
     */
    private function logEnergyRefill(): string
    {
        return "Energy was refilled! Car has currently " . $this->energySource->getCurrentSourceAmount() . " amount of energy.\n";
    }
}