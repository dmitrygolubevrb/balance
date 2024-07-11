<?php


namespace App\Services;


use App\Interfaces\WebsocketInterface;
use WebSocket\Client;

class WebsocketService implements WebsocketInterface
{

    public $socket;

    public function __construct()
    {
        $this->socket = new Client("wss://toazkpp.uc.local:6001");
    }

    public function send($data)
    {
        $this->socket->send(json_encode($data));
        $this->close();
    }

    public function close()
    {
        $this->socket->close();
    }
}
