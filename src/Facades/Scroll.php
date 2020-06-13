<?php


namespace Sowren\Scroll\Facades;


use Illuminate\Support\Facades\Facade;

class Scroll extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Scroll';
    }
}
