<?php

namespace NextDeveloper\Vinchin\Services;

Interface ServiceInterface
{
    public function get(array $parameters = []);

    public function create(array $data);

    public function update(array $data);

    public function delete(array $data);
}
