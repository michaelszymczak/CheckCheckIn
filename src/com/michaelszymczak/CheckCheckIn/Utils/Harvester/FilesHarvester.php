<?php
namespace com\michaelszymczak\CheckCheckIn\Utils\Harvester;
use com\michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComposite;
use \com\michaelszymczak\CheckCheckIn\Utils\Executor\Executor;

class FilesHarvester extends ExecutorAwareComposite
{
    public function process(Executor $executor = null)
    {
        return array_values(array_unique(parent::process($executor)));
    }
}