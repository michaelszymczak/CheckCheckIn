<?php
namespace michaelszymczak\CheckCheckIn\Response;

class InfoResponse extends Response {
    public function render(ResponseRenderer $renderer) {
        return $renderer->info($this->getMessage());
    }
}
