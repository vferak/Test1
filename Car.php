<?php


class Car
{
    const MIN_TANK_VOLUME = 0;
    const MAX_TANK_VOLUME = 60;

    const MIN_SPEED = 0;
    const MAX_SPEED = 5;

    const STARTING_DISTANCE = 0;

    private int $currentSpeed;

    private int $currentOilInTank;

    private int $distanceDriven;

    /**
     * Car constructor.
     * @param int $oilInTank Sets the current amount of oil in tank.
     * @throws CarException
     */
    public function __construct(int $oilInTank)
    {
        if ($oilInTank < self::MIN_TANK_VOLUME || $oilInTank > self::MAX_TANK_VOLUME) {
            throw new CarException("Amount of oil in tank in the initialization of the car is out of boundaries! Set it between " . self::MIN_TANK_VOLUME . " and " . self::MAX_TANK_VOLUME . ".");
        }

        $this->currentOilInTank = $oilInTank;

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
            if ($this->currentOilInTank == self::MIN_TANK_VOLUME) {
                $this->stop();
                $this->refillOil();
                $routeLog .= $this->logOilRefill();
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
     * Uses oil based on currentSpeed. If currentSpeed is higher than currentOil, sets the speed to use the rest of the oil.
     */
    private function useOil(): void
    {
        if ($this->currentOilInTank < $this->currentSpeed) {
            $this->setSpeed($this->currentOilInTank);
        }

        $this->currentOilInTank -= $this->currentSpeed;
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

        $this->useOil();
        return $this->currentSpeed;
    }

    /**
     * Refills oil in the tank by a random amount between MIN and MAX volume of the tank.
     */
    private function refillOil(): void
    {
        $this->currentOilInTank = rand(self::MIN_TANK_VOLUME, self::MAX_TANK_VOLUME);
    }

    /**
     * Returns currents state of the car.
     * @return string
     */
    private function logCurrentState(): string
    {
        return "Car currently traveled for " . $this->distanceDriven . " km, has " . $this->currentOilInTank . " l of oil in tank and went in speed " . $this->currentSpeed . ".\n";
    }

    /**
     * Returns information about oil refill.
     * @return string
     */
    private function logOilRefill(): string
    {
        return "Oil was refilled! Car has currently " . $this->currentOilInTank . " l of oil in tank.\n";
    }
}