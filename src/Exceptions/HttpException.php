<?php

namespace NextDeveloper\Vinchin\Exceptions;

use Exception;

class HttpException extends Exception
{
    protected $statusCode;
    protected $defaultMessage;

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        if (!$message) {
            $message = $this->defaultMessage;
        }
        parent::__construct($message, $code, $previous);
    }

}
