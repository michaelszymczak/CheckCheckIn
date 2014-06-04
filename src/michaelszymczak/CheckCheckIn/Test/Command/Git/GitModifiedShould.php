<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;
use michaelszymczak\CheckCheckIn\Test\Command\CommandCompositeTestCase;
use \michaelszymczak\CheckCheckIn\Command\Git\GitModified;
use \Mockery as m;
/**
 * Class GitModifiedShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitModified
 * @covers \michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent
 */
class GitModifiedShould extends CommandCompositeTestCase
{
    /**
     * @test
     */
    public function execCommandListingModifiedButOnlyAddedCopiedModifiedAndUnmergedFilesIgnoringDeletedOnesAsTheyNoLongerExist()
    {
        $repoStateWithRemovedFiles = array('removed_foo.txt', 'modified_bar.txt');
        $repoStateWithoutRemovedFiles = array('modified_bar.txt');
        $this->executor->shouldReceive('exec')->with('git ls-files --modified')->andReturn($repoStateWithRemovedFiles);
        $this->executor->shouldReceive('exec')->with('git diff-files --name-only')->andReturn($repoStateWithRemovedFiles);
        $this->executor->shouldReceive('exec')->with('git diff-files --name-only --diff-filter=ACMU')->andReturn($repoStateWithoutRemovedFiles);

        $this->assertSame($repoStateWithoutRemovedFiles, $this->leaf->process($this->executor));
    }
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwExceptionIfNoExecutorPassed()
    {
        $this->leaf->process();
    }
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function throwExceptionIfExecutedCommandReturnsError()
    {
      $this->executor->shouldReceive('exec')->andThrow(new \RuntimeException());

      $this->leaf->process($this->executor);
    }

    protected $leaf;
    public function setUp()
    {
        parent::setUp();
        $this->leaf = new GitModified();
    }
}