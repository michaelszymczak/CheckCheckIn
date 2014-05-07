<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitUntrackedLeaf extends ExecutorAwareComponent
{
    public function getCommand()
    {
        return 'git ls-files --other --exclude-standard';
    }
}