<?php

namespace App\Facedes;


use Illuminate\Support\Facades\Facade;

class AdminFacedes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Models\Admin::class;
    }
}