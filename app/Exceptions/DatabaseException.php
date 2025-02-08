<?php

namespace App\Exceptions;

use Exception;

class DatabaseException extends Exception
{
    public function __construct($message = "Database Error", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
