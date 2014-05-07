<?php
namespace com\michaelszymczak\CheckCheckIn\Utils\Harvester;
use com\michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitStagedLeaf extends ExecutorAwareComponent
{
    public function getCommand()
    {
        return 'git diff-index --cached --name-only HEAD';
    }
}