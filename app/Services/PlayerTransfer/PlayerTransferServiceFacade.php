<?php

namespace App\Services\PlayerTransfer;

use Illuminate\Support\Facades\Facade;

class PlayerTransferServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\PlayerTransfer\PlayerTransferService';
    }
}
