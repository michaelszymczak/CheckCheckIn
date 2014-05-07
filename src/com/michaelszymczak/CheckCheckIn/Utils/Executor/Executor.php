<?php
namespace com\michaelszymczak\CheckCheckIn\Utils\Executor;

class Executor
{
    private $output;
    private $returnCode;
    private $command;
    public function exec($command)
    {
        $this->resetValues($command);
        $this->execute();
        $this->throwExceptionIfError();
        return $this->output;
    }
    private function resetValues($command)
    {
        $this->output = array();
        $this->returnCode = 0;
        $this->command = $command . " 2>&1";
    }
    private function execute()
    {
        exec($this->command, $this->output, $this->returnCode);
    }
    private function throwExceptionIfError()
    {
        if ($this->returnCode !== 0) {
            throw new \RuntimeException($this->prepareExceptionMessage());
        }
    }
    private function prepareExceptionMessage()
    {
        return 'Error when executing command ' . $this->command . '. RESULT: ' . var_export($this->output, true);
    }
}
