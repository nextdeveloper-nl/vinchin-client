<?php

namespace NextDeveloper\Vinchin\Services;

class AbstractService
{
    public function __construct()
    {
        //  We will be taking the connection information of vinchin server here
        //  We will use raw curl for connections not to create unnecessary overhead for other developers
    }

    public function get()
    {
        return new static();
    }

    public function create()
    {
        return $this->get();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
