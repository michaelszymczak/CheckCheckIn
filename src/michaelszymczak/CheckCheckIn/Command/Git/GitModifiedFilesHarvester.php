<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Processable;

class GitModifiedFilesHarvester extends GitFilesHarvester implements Processable
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