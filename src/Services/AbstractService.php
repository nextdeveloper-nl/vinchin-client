<?php

namespace NextDeveloper\Vinchin\Services;

class AbstractService
{
    public function __construct($client) {
        $this->client = $client;
    }

    public function get($parameter) {
        //  Burada CURL request'i atılacak.
    }
}
