<?php
namespace michaelszymczak\CheckCheckIn\Command\Git;

use michaelszymczak\CheckCheckIn\Utils\Filter\Filter;

class FilteredGitFilesRetriever
{

    private $harvester;
    private $blacklist;

    public function __construct(GitFilesHarvester $harvester, $blacklist)
    {
        $this->harvester = $harvester;
        $this->blacklist = $blacklist;
    }

    public function getFiles($group)
    {
        $filter = new Filter($group->getFilePatterns(), $this->blacklist);
        return array_map('escapeshellarg', $filter->filter($this->harvester->process()));
    }
    public function getBlacklist()
    {
        return $this->blacklist;
    }
    public function getHarvester()
    {
        return $this->harvester;
    }


}