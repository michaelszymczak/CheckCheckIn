<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils;

use \michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;

/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor
 * @covers \michaelszymczak\CheckCheckIn\Command\Executor\Executor
 *
 */
class BadNewsOnlyExecutorShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function notReturnOutputWhenCommandWasSuccessful()
    {
        $this->assertSame(array(), $this->executor->exec('echo "foo"'));
    }
    /**
     * @test
     */
    public function returnOutputWhenCommandFailed()
    {
        $this->assertNotEmpty($this->executor->exec('thisCommandIsWrong'));
    }


    private $executor;
    public function setUp()
    {
        $this->executor = new BadNewsOnlyExecutor();
    }
}
