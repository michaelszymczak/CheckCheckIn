<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils;
use \michaelszymczak\CheckCheckIn\Command\Executor;

/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Executor
 *
 */
class ExecutorShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnOutputAsTextInsideArrayAfterRunningCommandFromParameter()
    {
        $this->assertSame(array('foo'), $this->executor->exec('echo "foo"'));
    }
    /**
     * @test
     */
    public function returnArrayOfLinesWhenOutputLongerThanOneLine()
    {
        $this->assertGreaterThan(1, count($this->executor->exec('man echo')));
    }
    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Error when executing command
     */
    public function throwExceptionWhenCommandFailed()
    {
        $this->executor->exec('thisCommandIsWrong');
    }


    private $executor;
    public function setUp()
    {
        $this->executor = new Executor();
    }
}
