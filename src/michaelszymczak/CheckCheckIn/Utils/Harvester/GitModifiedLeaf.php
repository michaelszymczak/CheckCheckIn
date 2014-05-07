<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitModifiedLeaf extends ExecutorAwareComponent
{
    public function getCommand()
    {
        return 'git ls-files --modified';
    }
}