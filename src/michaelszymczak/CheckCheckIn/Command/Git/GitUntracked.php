<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;
use michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent;

class GitUntracked extends ExecutorAwareComponent
{
    public function getCommands()
    {
        return array('git ls-files --other --exclude-standard');
    }
}