<?php
namespace michaelszymczak\CheckCheckIn\Response;

interface ResponseRenderer
{
    public function error($messages);
    public function info($messages);
    public function success($messages);
}
