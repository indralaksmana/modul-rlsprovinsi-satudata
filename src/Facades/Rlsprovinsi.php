<?php namespace Satudata\Rlsprovinsi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Rlsprovinsi facade.
 *
 * @package Satudata\Rlsprovinsi
 * @author  MKI <info@mkitech.net>
 */
class Rlsprovinsi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rlsprovinsi';
    }
}
