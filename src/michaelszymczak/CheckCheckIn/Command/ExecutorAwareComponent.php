<?php
namespace michaelszymczak\CheckCheckIn\Command;

use \michaelszymczak\CheckCheckIn\Command\Executor;

abstract class ExecutorAwareComponent implements Processable
{
    public function process(Executor $executor = null)
    {
        $this->throwExceptionIfNoExecutorPassed($executor);
        $commands = $this->getCommands();
        try {

          return $executor->exec($commands[0]);
        } catch(\RuntimeException $e) {
          if (count($commands) == 1) {
            throw $e;
          }

          return $executor->exec($commands[1]);
        }
    }

    protected abstract function getCommands();

    private function throwExceptionIfNoExecutorPassed($executor)
    {
        if (null === $executor) {
            throw new \InvalidArgumentException('Executor must be passed');
        }
    }
}