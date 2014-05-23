<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
use \Mockery as m;
use michaelszymczak\CheckCheckIn\Command\CommandComposite;

abstract class CommandCompositeTestCase extends \PHPUnit_Framework_TestCase
{
    protected $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor');
    }
    public function tearDown()
    {
        m::close();
    }
    protected function getComposite()
    {
        return new CommandComposite($this->executor);
    }
}
