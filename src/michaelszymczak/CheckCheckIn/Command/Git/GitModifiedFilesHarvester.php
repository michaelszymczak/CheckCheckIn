<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\Executor;

class GitModifiedFilesHarvester extends GitFilesHarvester
{
    public function process()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitUntracked());
        $harvester->addComponent(new GitModified());
        $harvester->addComponent(new GitStaged());

        return $harvester->process();
    }

}