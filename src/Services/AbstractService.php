<?php

namespace NextDeveloper\Vinchin\Services;

use NextDeveloper\Vinchin\Clients\CurlClient;

class AbstractService
{

    protected CurlClient $client;

    public function __construct(CurlClient $client) {
        $this->client = $client;
    }

}
