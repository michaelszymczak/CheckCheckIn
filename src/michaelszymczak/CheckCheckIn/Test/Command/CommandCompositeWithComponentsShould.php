<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
use \Mockery as m;
/**
 * @covers \michaelszymczak\CheckCheckIn\Command\CommandComposite
 * @group wip
 */
class CommandCompositeWithComponentsShould extends CommandCompositeTestCase
{
    /**
     * @test
     */
    public function processUsingSameExecutorOnAllComponents()
    {
        $this->component1->shouldReceive('process')->with($this->executor)->once()->andReturn(array());
        $this->component2->shouldReceive('process')->with($this->executor)->once()->andReturn(array());
        $this->component3->shouldReceive('process')->with($this->executor)->once()->andReturn(array());
        $this->composite->process($this->executor);
    }
    /**
     * @test
     */
    public function returnResultAsSumOfAllComponentResults()
    {
        $this->component1->shouldReceive('process')->andReturn(array('foo'));
        $this->component2->shouldReceive('process')->andReturn(array('bar', 'foo'));
        $this->component3->shouldReceive('process')->andReturn(array('bar', 'baz', 'goo'));
        $expected = array('foo', 'bar', 'foo', 'bar', 'baz', 'goo');
        $this->assertSame($expected, $this->composite->process($this->executor));
    }
    /**
     * @test
     */
    public function returnEmptyResultIfAllComponentsReturnedEmptyResult()
    {
        $this->component1->shouldReceive('process')->andReturn(array());
        $this->component2->shouldReceive('process')->andReturn(array());
        $this->component3->shouldReceive('process')->andReturn(array());
        $expected = array();
        $this->assertSame($expected, $this->composite->process($this->executor));
    }



    private $composite;
    private $component1;
    private $component2;
    private $component3;
    public function setUp()
    {
        parent::setUp();
        $this->composite = $this->getComposite();
    }
    protected function getComposite()
    {
        $composite = parent::getComposite();
        $this->component1 = m::mock('\michaelszymczak\CheckCheckIn\Command\CommandComposite');
        $this->component2 = m::mock('\michaelszymczak\CheckCheckIn\Command\CommandComposite');
        $this->component3 = m::mock('\michaelszymczak\CheckCheckIn\Command\CommandComposite');
        $composite->addComponent($this->component1);
        $composite->addComponent($this->component2);
        $composite->addComponent($this->component3);
        return $composite;
    }
}
