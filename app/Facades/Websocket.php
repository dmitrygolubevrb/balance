<?php


namespace App\Facades;



use Illuminate\Support\Facades\Facade;

/**
 * @method static send($data)
 */
class Websocket extends Facade
{
    /**
     * Созданный фасад для упрощения работы с классом Websocket
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'websocket.service';
    }

}
