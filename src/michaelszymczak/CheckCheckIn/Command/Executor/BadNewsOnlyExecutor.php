<?php
namespace michaelszymczak\CheckCheckIn\Command\Executor;

class BadNewsOnlyExecutor extends Executor
{
    protected function executeAndReturnOutput($command)
    {
        $returnCode = 0;
        $output = array();
        exec($command, $output, $returnCode);
        if ($returnCode !== 0) {
            return $output;
        }

        return array();
    }
}
