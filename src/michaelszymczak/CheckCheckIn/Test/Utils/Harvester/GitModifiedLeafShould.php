<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Test\Utils\Composite\CompositeTestCase;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf;
use \Mockery as m;
/**
 * Class GitModifiedLeafShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf
 * @covers \michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent
 */
class GitModifiedLeafShould extends CompositeTestCase
{
    /**
     * @test
     */
    public function execCommandListingAllGitModifiedFiles()
    {
        $execResult = array('foo');
        $this->executor->shouldReceive('exec')->with('git ls-files --modified')->once()->andReturn($execResult);
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
        $this->leaf = new GitModifiedLeaf();
    }
}