<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitModified extends ExecutorAwareComponent
{
    public function getCommands()
    {
        return array('git ls-files --modified');
    }
}