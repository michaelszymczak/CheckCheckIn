<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use michaelszymczak\CheckCheckIn\Test\Utils\Composite\CompositeTestCase;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\GitUntrackedLeaf;
use \Mockery as m;
/**
 * Class GitUntrackedLeafShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Utils\Harvester\GitUntrackedLeaf
 * @covers \michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComponent
 */
class GitUntrackedLeafShould extends CompositeTestCase
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
        $this->leaf = new GitUntrackedLeaf();
    }
}