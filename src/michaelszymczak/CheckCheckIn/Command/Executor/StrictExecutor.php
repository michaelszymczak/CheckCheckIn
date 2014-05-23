<?php
namespace michaelszymczak\CheckCheckIn\Command\Executor;

class StrictExecutor extends Executor
{
    protected function executeAndReturnOutput($command)
    {
        $returnCode = 0;
        $output = array();
        exec($command, $output, $returnCode);
        $this->throwExceptionIfError($command, $output, $returnCode);

        return $output;
    }

    private function throwExceptionIfError($command, $output, $returnCode)
    {
        if ($returnCode !== 0) {
            throw new \RuntimeException($this->prepareExceptionMessage($command, $output));
        }
    }

    private function prepareExceptionMessage($command, $output)
    {
        return 'Error when executing command ' . $command . '. RESULT: ' . var_export($output, true);
    }
}
