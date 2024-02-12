<?php

namespace Ashraafdev\CloudinaryLaravel;

use Throwable;
use Exception;

class FileSystemException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
