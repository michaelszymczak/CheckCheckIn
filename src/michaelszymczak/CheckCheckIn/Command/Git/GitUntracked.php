<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitUntracked extends ExecutorAwareComponent
{
    public function getCommands()
    {
        return array('git ls-files --other --exclude-standard');
    }
}