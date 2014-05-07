<?php
namespace com\michaelszymczak\CheckCheckIn\Test\Utils\Composite;
use \Mockery as m;
use com\michaelszymczak\CheckCheckIn\Utils\Composite\ExecutorAwareComposite;

abstract class CompositeTestCase extends \PHPUnit_Framework_TestCase
{
    protected $executor;
    public function setUp()
    {
        $this->executor = m::mock('\com\michaelszymczak\CheckCheckIn\Utils\Executor\Executor');
    }
    public function tearDown()
    {
        m::close();
    }
    protected function getComposite()
    {
        return new ExecutorAwareComposite($this->executor);
    }
}
