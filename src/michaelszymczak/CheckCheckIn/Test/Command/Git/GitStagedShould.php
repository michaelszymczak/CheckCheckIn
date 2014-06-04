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
    public function execCommandListingStagedButOnlyAddedCopiedModifiedAndUnmergedFilesIgnoringDeletedOnesAsTheyNoLongerExist()
    {
        $repoStateWithRemovedFiles = array('removed_foo.txt', 'modified_bar.txt');
        $repoStateWithoutRemovedFiles = array('modified_bar.txt');
        $this->executor->shouldReceive('exec')->with('git diff-index --cached --name-only HEAD')->andReturn($repoStateWithRemovedFiles);
        $this->executor->shouldReceive('exec')->with('git diff-index --cached --name-only --diff-filter=ACMU HEAD')->andReturn($repoStateWithoutRemovedFiles);

        $this->assertSame($repoStateWithoutRemovedFiles, $this->leaf->process($this->executor));
    }
    /**
     * @test
     */
    public function useUniversalBaseHashIfNoHEADinNotYetCommitedRepository()
    {
        $this->executor->shouldReceive('exec')
            ->with('git diff-index --cached --name-only --diff-filter=ACMU HEAD')
            ->andThrow(new \RuntimeException());
        $this->executor->shouldReceive('exec')
            ->with('git diff-index --cached --name-only --diff-filter=ACMU 4b825dc642cb6eb9a060e54bf8d69288fbee4904')
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
