<?php

namespace Trayto;


class CarException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Object of class Car threw an exception: " . $message;
        parent::__construct($message, $code, $previous);
    }
}