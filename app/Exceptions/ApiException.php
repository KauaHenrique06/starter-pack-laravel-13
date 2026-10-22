<?php

namespace App\Exceptions;

use App\Support\ReturnApi;
use Exception;

class ApiException extends Exception
{
    protected $code = 500; 
    protected $message = "Server internal error!"; 
    public $data = [];

    public function __construct(?string $message = null, ?int $code = null, ?array $data = null)
    {
        $this->message = $message ?? $this->message;
        $this->code = $code ?? $this->code;
        $this->data = $data ?? $this->data;

        parent::__construct($this->message, $this->code);
    }

    public function render()
    {
        return ReturnApi::error($this->data, $this->message, $this->code);
    }
}
