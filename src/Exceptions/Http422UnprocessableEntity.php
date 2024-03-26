<?php

namespace NextDeveloper\Vinchin\Exceptions;


class Http422UnprocessableEntity extends HttpException
{
    protected $statusCode = 422;
    protected $defaultMessage = 'Unprocessable Entity, the server understands the content type of the request entity,
    and the syntax of the request entity is correct, but it was unable to process the contained instructions';
}
