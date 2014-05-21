<?php
namespace michaelszymczak\CheckCheckIn\Response;

class ErrorResponse extends Response {
    public function render(ResponseRenderer $renderer) {
        return $renderer->error($this->getMessage());
    }
}
