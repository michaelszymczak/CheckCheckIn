<?php
namespace com\michaelszymczak\CheckCheckIn\Utils\Harvester;
use com\michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitModifiedLeaf extends ExecutorAwareComponent
{
    public function getCommand()
    {
        return 'git ls-files --modified';
    }
}