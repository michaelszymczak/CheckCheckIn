<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\Executor;
use michaelszymczak\CheckCheckIn\Command\Processable;
use michaelszymczak\CheckCheckIn\Command\CommandUniqueResultsComposite;

abstract class GitFilesHarvester implements Processable
{
    private $executor;
    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }

    public function getExecutor()
    {
        return $this->executor;
    }

    public abstract function process();

    protected function prepareHarvester()
    {
        return new CommandUniqueResultsComposite($this->executor);
    }
}