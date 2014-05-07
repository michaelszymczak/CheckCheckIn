<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitStagedLeaf extends ExecutorAwareComponent
{
    public function getCommand()
    {
        return 'git diff-index --cached --name-only HEAD';
    }
}