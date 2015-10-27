<?php
/*
Factory Design Pattern
We Have an object Automobile and an AutomobileFactory Class which makes an object from AutomobileClass
*/
class Automobile
{
    private $vehicleMake;
    private $vehicleModel;

    public function __construct($make, $model)
    {
        $this->vehicleMake = $make;
        $this->vehicleModel = $model;
    }

    public function getMakeAndModel()
    {
        return $this->vehicleMake . ' ' . $this->vehicleModel;
    }
}

class AutomobileFactory
{
    public static function create($make, $model)
    {
        return new Automobile($make, $model);
    }
}

// have the factory create the Automobile object
$Aventador = AutomobileFactory::create('Lomborghini', 'Aventador');

print_r($Aventador->getMakeAndModel()); // outputs "Lomborghinni Aventador"