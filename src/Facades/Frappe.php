<?php

namespace Romb2on\Frappe\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Romb2on\Frappe\Frappe
 */
class Frappe extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Romb2on\Frappe\Frappe::class;
    }
}
