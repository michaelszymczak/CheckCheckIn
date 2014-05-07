<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitUntrackedLeaf extends ExecutorAwareComponent
{
    public function getCommands()
    {
        return array('git ls-files --other --exclude-standard');
    }
}