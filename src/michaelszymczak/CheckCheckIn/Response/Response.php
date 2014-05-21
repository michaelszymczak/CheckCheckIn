<?php
namespace michaelszymczak\CheckCheckIn\Response;

abstract class Response {
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public abstract function render(ResponseRenderer $renderer);
}
