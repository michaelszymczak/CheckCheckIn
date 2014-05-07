<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComposite;
use \michaelszymczak\CheckCheckIn\Utils\Executor\Executor;

class FilesHarvester extends ExecutorAwareComposite
{
    public function process(Executor $executor = null)
    {
        return array_values(array_unique(parent::process($executor)));
    }
}