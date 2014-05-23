<?php
namespace michaelszymczak\CheckCheckIn\Command;

class CommandUniqueResultsComposite extends CommandComposite
{
    public function process(Executor $executor = null)
    {
        return array_values(array_unique(parent::process($executor)));
    }
}