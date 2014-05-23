<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;
use michaelszymczak\CheckCheckIn\Test\Command\CommandCompositeTestCase;
use \michaelszymczak\CheckCheckIn\Command\Git\GitStaged;
use \Mockery as m;

/**
 * Class GitStagedShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitStaged
 * @covers \michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent
 */
class GitStagedShould extends CommandCompositeTestCase
{
    /**
     * @test
     */
    public function execCommandListingAllGitStagedFiles()
    {
        $execResult = array('foo');
        $this->executor->shouldReceive('exec')->with('git diff-index --cached --name-only HEAD')->once()->andReturn($execResult);
        $this->assertSame($execResult, $this->leaf->process($this->executor));
    }
    /**
     * @test
     */
    public function useUniversalBaseHashIfNoHEADinNotYetCommitedRepository()
    {
        $this->executor->shouldReceive('exec')
            ->with('git diff-index --cached --name-only HEAD')
            ->andThrow(new \RuntimeException());
        $this->executor->shouldReceive('exec')
            ->with('git diff-index --cached --name-only 4b825dc642cb6eb9a060e54bf8d69288fbee4904')
            ->andReturn(array('stagedFileInNotYetCommitedRepo.txt'));

        $this->assertSame(array('stagedFileInNotYetCommitedRepo.txt'), $this->leaf->process($this->executor));
    }
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwExceptionIfNoExecutorPassed()
    {
        $this->leaf->process();
    }


    protected $leaf;
    public function setUp()
    {
        parent::setUp();
        $this->leaf = new GitStaged();
    }
}
