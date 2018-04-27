<?php

namespace LibreNMS\Exceptions;

use Throwable;

class JsonAppPollingFailedException extends \Exception
{
    private $output;

    public function __construct($message, $output, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->output = $output;
    }

    public function getOutput()
    {
        return $this->output;
    }
}
