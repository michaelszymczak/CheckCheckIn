<?php
namespace michaelszymczak\CheckCheckIn\Utils\Harvester;
use \michaelszymczak\CheckCheckIn\Utils\Executor\Executor;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester;

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
        $harvester->addComponent(new GitStagedLeaf());
        return $harvester;
    }

    public function allCandidates()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitUntrackedLeaf());
        $harvester->addComponent(new GitModifiedLeaf());
        $harvester->addComponent(new GitStagedLeaf());
        return $harvester;
    }

    private function prepareHarvester()
    {
        return new FilesHarvester($this->executor);
    }
}