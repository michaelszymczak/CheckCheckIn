<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\Executor;

class GitStagedFilesHarvester extends GitFilesHarvester
{
    public function process()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitStaged());

        return $harvester->process();
    }

}