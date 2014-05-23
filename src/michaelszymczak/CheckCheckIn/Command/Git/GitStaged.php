<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;
use michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent;

class GitStaged extends ExecutorAwareComponent
{
    public function getCommands()
    {
        $lastCommitedRepositoryHash = 'HEAD';
        $beginningRepositoryHash = '4b825dc642cb6eb9a060e54bf8d69288fbee4904';
        $stagedFilesListing = 'git diff-index --cached --name-only ';

        return array(
          $stagedFilesListing.$lastCommitedRepositoryHash,
          $stagedFilesListing.$beginningRepositoryHash
        );
    }
}