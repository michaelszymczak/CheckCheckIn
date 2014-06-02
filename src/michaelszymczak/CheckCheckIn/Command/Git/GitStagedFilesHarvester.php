<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Processable;

class GitStagedFilesHarvester extends GitFilesHarvester implements Processable
{
    public function process()
    {
        $harvester = $this->prepareHarvester();
        $harvester->addComponent(new GitStaged());

        return $harvester->process();
    }

}