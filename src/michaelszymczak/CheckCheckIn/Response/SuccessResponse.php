<?php
namespace michaelszymczak\CheckCheckIn\Response;

class SuccessResponse extends Response {
    public function render(ResponseRenderer $renderer) {
        return $renderer->success($this->getMessage());
    }
}
