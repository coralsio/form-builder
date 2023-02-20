<?php

namespace Corals\Modules\FormBuilder\Facades;

use Illuminate\Support\Facades\Facade;

class FormBuilder extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\FormBuilder\Classes\FormBuilder::class;
    }
}
