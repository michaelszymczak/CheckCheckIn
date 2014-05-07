<?php
namespace com\michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use com\michaelszymczak\CheckCheckIn\Test\Utils\Composite\CompositeTestCase;
use \com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf;
use \Mockery as m;
/**
 * Class GitModifiedLeafShould.
 *
 * @covers \com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf
 * @covers \com\michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent
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