<?php
namespace michaelszymczak\CheckCheckIn\Command\Executor;

abstract class Executor {
    public function exec($command)
    {
        return $this->executeAndReturnOutput($command . " 2>&1");
    }

    abstract protected function executeAndReturnOutput($command);
}
