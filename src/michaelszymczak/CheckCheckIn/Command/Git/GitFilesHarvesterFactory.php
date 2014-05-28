<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\StrictExecutor;

class GitFilesHarvesterFactory
{
    public function createForModified()
    {
        return new GitModifiedFilesHarvester(new StrictExecutor());
    }
    public function createForStaged()
    {
        return new GitStagedFilesHarvester(new StrictExecutor());
    }
}