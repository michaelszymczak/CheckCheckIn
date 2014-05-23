<?php
namespace michaelszymczak\CheckCheckIn\Command;

class CustomCommand extends ExecutorAwareComponent
{
    private $customCommand;

    public function __construct($customCommand)
    {
        $this->customCommand = $customCommand;
    }
    public function getCommands()
    {
        return array($this->customCommand);
    }
}