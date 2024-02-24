<?php namespace App\Libraries;

use CodeIgniter\I18n\Time;

class Reloj {

    private $time;

    public function __construct()
    {
        // En un principio, el reloj mostrará la hora actual.
        $this->time = Time::now();
    }

    public function getTime()
    {
        return $this->time;
    }

    // Usar este método en el entorno de desarrollo para manipular la hora.
    public function setTime(string $time)
    {
        $this->time = Time::parse($time);
    }
}