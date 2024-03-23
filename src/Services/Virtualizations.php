<?php

namespace NextDeveloper\Vinchin\Services;

class Virtualizations extends AbstractService implements ServiceInterface
{
    public function __construct($config)
    {
        //  We will be taking the connection information of vinchin server here
        //  We will use raw curl for connections not to create unnecessary overhead for other developers
    }

    public function getVirtualizations()
    {
        $url = '....';

        $list = $this->get([
            'url' => $url,
            'params'    => '....'
        ]);

        return $list;
    }
}
