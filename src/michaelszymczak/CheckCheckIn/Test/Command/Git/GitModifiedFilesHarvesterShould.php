<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
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
        $this->repositoryContains(array(
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
        $this->repositoryContains(array(
            'modified' => array('modified.txt'),
            'staged' => array(),
            'untracked' => array('foo/bar/foo.txt')
        ));

        $this->assertSame(array('foo/bar/foo.txt', 'modified.txt'), $this->harvester->process());
    }


    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\Executor');
        $this->harvester = new GitModifiedFilesHarvester($this->executor);
    }

    private function repositoryContains($files)
    {
        $this->executor->shouldReceive('exec')->with('git ls-files --modified')->andReturn($files['modified']);
        $this->executor->shouldReceive('exec')->with('git diff-index --cached --name-only HEAD')->andReturn($files['staged']);
        $this->executor->shouldReceive('exec')->with('git ls-files --other --exclude-standard')->andReturn($files['untracked']);
    }
}

