<?php


namespace App\Interfaces;

interface WebsocketInterface
{

    public function send($data);

    public function close();

}
