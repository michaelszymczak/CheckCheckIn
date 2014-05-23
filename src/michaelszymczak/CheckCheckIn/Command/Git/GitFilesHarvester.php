<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\Executor;
use michaelszymczak\CheckCheckIn\Command\CommandUniqueResultsComposite;

class GitFilesHarvester
{
    private $executor;
    public function __construct(Executor $executor)
    {
        $this->executor = $executor;
    }

    public function toBeCommited()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitStaged());
        return $harvester;
    }

    public function allCandidates()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitUntracked());
        $harvester->addComponent(new GitModified());
        $harvester->addComponent(new GitStaged());
        return $harvester;
    }

    private function prepareHarvester()
    {
        return new CommandUniqueResultsComposite($this->executor);
    }
}