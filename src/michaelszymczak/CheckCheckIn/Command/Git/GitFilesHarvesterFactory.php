<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\StrictExecutor;

class GitFilesHarvesterFactory
{
    private $modifiedHarvester = null;
    private $stagedHarvester = null;

    public function createForModified()
    {
        if (null === $this->modifiedHarvester) {
            $this->modifiedHarvester = new GitModifiedFilesHarvester(new StrictExecutor());
        }

        return $this->modifiedHarvester;
    }
    public function createForStaged()
    {
        if (null === $this->stagedHarvester) {
            $this->stagedHarvester = new GitStagedFilesHarvester(new StrictExecutor());
        }

        return $this->stagedHarvester;
    }
}