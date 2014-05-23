<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;
use michaelszymczak\CheckCheckIn\Test\Command\CommandCompositeTestCase;
use \michaelszymczak\CheckCheckIn\Command\Git\GitUntracked;
use \Mockery as m;
/**
 * Class GitUntrackedShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitUntracked
 * @covers \michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent
 */
class GitUntrackedShould extends CommandCompositeTestCase
{
    /**
     * @test
     */
    public function execCommandListingAllGitUntrackedFiles()
    {
        $execResult = array('someUntrackedFile.txt');
        $this->executor->shouldReceive('exec')->with('git ls-files --other --exclude-standard')->once()->andReturn($execResult);
        $this->assertSame($execResult, $this->leaf->process($this->executor));

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
        $this->leaf = new GitUntracked();
    }
}