<?php
namespace michaelszymczak\CheckCheckIn\Utils\Composite;
use \michaelszymczak\CheckCheckIn\Utils\Executor\Executor;

abstract class ExecutorAwareComponent implements Processable
{
    public function process(Executor $executor = null)
    {
        $this->throwExceptionIfNoExecutorPassed($executor);

        return $executor->exec($this->getCommand());
    }

    protected abstract function getCommand();

    private function throwExceptionIfNoExecutorPassed($executor)
    {
        if (null === $executor) {
            throw new \InvalidArgumentException('Executor must be passed');
        }
    }
}