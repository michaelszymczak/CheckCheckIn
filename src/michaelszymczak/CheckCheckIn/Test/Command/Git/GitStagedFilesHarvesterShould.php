<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;

use \michaelszymczak\CheckCheckIn\Command\Git\GitStagedFilesHarvester;
use \Mockery as m;

/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitStagedFilesHarvester
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester
 *
 */
class GitStagedFilesHarvesterShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function beGitFilesHarvester()
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester', $this->harvester);
    }
    /**
     * @test
     */
    public function createHarvesterListingAllModifiedFilesRegardlessOfTheirCurrentState()
    {
        $this->repoSimulatingExecutor->configure(array(
            'modified' => array('modified.txt', 'staged.txt'),
            'staged' => array('staged.txt', 'foo/bar/fooStaged.txt'),
            'untracked' => array('untracked.txt')
        ));

        $this->assertSame(array('staged.txt', 'foo/bar/fooStaged.txt'), $this->harvester->process());
    }
    /**
     * @test
     */
    public function createHarvesterListingAllModifiedFilesRegardlessOfTheirCurrentState2()
    {
        $this->repoSimulatingExecutor->configure(array(
            'modified' => array('modified.txt'),
            'staged' => array(),
            'untracked' => array('foo/bar/foo.txt')
        ));

        $this->assertSame(array(), $this->harvester->process());
    }


    private $repoSimulatingExecutor;
    private $harvester;

    public function setUp()
    {
        $this->repoSimulatingExecutor = new ExecutorSimulatingRepositoryStateTest();
        $this->harvester = new GitStagedFilesHarvester($this->repoSimulatingExecutor);
    }
}

