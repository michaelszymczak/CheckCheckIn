<?php
namespace michaelszymczak\CheckCheckIn\Response;

interface ResponseRenderer
{
    public function error($message);
    public function info($message);
    public function success($message);
}
