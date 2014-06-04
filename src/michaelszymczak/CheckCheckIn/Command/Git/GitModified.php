<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;
use michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent;

class GitModified extends ExecutorAwareComponent
{
    public function getCommands()
    {
        return array('git diff-files --name-only --diff-filter=ACMU');
    }
}