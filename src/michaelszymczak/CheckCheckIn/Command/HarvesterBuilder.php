<?php
namespace michaelszymczak\CheckCheckIn\Command;
use \michaelszymczak\CheckCheckIn\Utils\Executor\Executor;
use \michaelszymczak\CheckCheckIn\Command\Git\GitUntracked;
use \michaelszymczak\CheckCheckIn\Command\Git\GitModified;
use \michaelszymczak\CheckCheckIn\Command\Git\GitStaged;

class HarvesterBuilder
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
        return new FilesHarvester($this->executor);
    }
}