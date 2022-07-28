<?php

namespace App\Exceptions;

class InvalidSeeddataException extends \Exception
{
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        $msg = $this->generateMessage($message, $code);
        parent::__construct($msg, $code, $previous);
    }

    public function __toString()
    {
        return $this->generateMessage($this->message, $this->code);
    }

    private function generateMessage($message, $code)
    {
        return __CLASS__ . "(code: {$code}): .{$message} file is invalid format.";
    }
}
