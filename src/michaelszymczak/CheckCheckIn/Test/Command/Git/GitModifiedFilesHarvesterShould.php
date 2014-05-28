<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;

use \michaelszymczak\CheckCheckIn\Command\Git\GitModifiedFilesHarvester;
use \Mockery as m;

/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitModifiedFilesHarvester
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester
 *
 */
class GitModifiedFilesHarvesterShould extends \PHPUnit_Framework_TestCase
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
            'staged' => array('staged.txt'),
            'untracked' => array('untracked.txt')
        ));

        $this->assertSame(array('untracked.txt', 'modified.txt', 'staged.txt'), $this->harvester->process());
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

        $this->assertSame(array('foo/bar/foo.txt', 'modified.txt'), $this->harvester->process());
    }


    private $repoSimulatingExecutor;
    private $harvester;

    public function setUp()
    {
        $this->repoSimulatingExecutor = new ExecutorSimulatingRepositoryStateTest();
        $this->harvester = new GitModifiedFilesHarvester($this->repoSimulatingExecutor);
    }
}

