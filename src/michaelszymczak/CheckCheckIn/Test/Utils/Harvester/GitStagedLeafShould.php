<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Test\Utils\Composite\CompositeTestCase;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf;
use \Mockery as m;

/**
 * Class GitStagedLeafShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf
 * @covers \michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent
 */
class GitStagedLeafShould extends CompositeTestCase
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
        $this->leaf = new GitStagedLeaf();
    }
}
