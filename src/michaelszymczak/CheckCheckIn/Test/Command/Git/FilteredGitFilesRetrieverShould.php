<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;

use \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever;
use \Mockery as m;

/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever
 *
 */
class FilteredGitFilesRetrieverShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnAllFilesMatchingPatternOfGivenGroupExcludingBlacklisted()
    {
        $filteredGitFiles = $this->createFilteredGitFilesConfiguredThat(array(
            'blacklist' => array('/bar/', '/baz/'),
            'gitCandidates' => array('foo1', 'FOO2', 'bar3', 'baz4', 'bazbaz5', 'BAZ6')
        ));

        $returnedFiles = $filteredGitFiles->getFiles(
            $this->createGroupWithFilePatterns(array('/^[fb]/', '/^[B]/'))
        );

        $this->assertContainsFilenames(array('foo1', 'BAZ6'), $returnedFiles);
    }
    /**
     * @test
     */
    public function escapeFilesSoThatTHeyCanBeUsedAsShellParameters()
    {
        $filteredGitFiles = $this->createFilteredGitFilesConfiguredThat(array(
            'blacklist' => array('/bar/'),
            'gitCandidates' => array("fo'o1", "bar2")
        ));

        $returnedFiles = $filteredGitFiles->getFiles($this->createGroupAllowingAllFiles());

        $this->assertSame(array("'fo'\\''o1'"), $returnedFiles);
    }



    private function createFilteredGitFilesConfiguredThat($params)
    {
        $harvester = m::mock('\michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester');
        $harvester->shouldReceive('process')->andReturn($params['gitCandidates']);

        return new FilteredGitFilesRetriever($harvester, $params['blacklist']);
    }

    private function createGroupWithFilePatterns($groupFilePatterns)
    {
        $group = m::mock('\michaelszymczak\CheckCheckIn\Configuration\Group');
        $group->shouldReceive('getFilePatterns')->andReturn($groupFilePatterns);
        return $group;
    }

    private function createGroupAllowingAllFiles()
    {
        return $this->createGroupWithFilePatterns(array('/.+/'));
    }

    private function assertContainsFilenames($expectedFilenames, $returnedFiles)
    {
        $cleanedReturnedFiles = preg_replace('/[^A-Za-z0-9_]+/', '', $returnedFiles);
        $this->assertSame($expectedFilenames, $cleanedReturnedFiles);
    }

}

