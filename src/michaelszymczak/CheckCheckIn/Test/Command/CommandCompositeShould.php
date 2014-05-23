<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
use \Mockery as m;
/**
 * @covers \michaelszymczak\CheckCheckIn\Command\CommandComposite
 */
class CommandCompositeShould extends CommandCompositeTestCase
{
    /**
     * @test
     */
    public function haveNoComponentsInitially()
    {
        $harvester = $this->getComposite();
        $this->assertCount(0, $harvester->getComponents());
    }
    /**
     * @test
     */
    public function beAbleToReceiveComponents()
    {
        $composite = $this->getComposite();
        $component1 = $this->getComposite();
        $component2 = $this->getComposite();
        $composite->addComponent($component1);
        $composite->addComponent($component2);
        $expected = array($component1, $component2);
        $this->assertEquals($expected, $composite->getComponents());
    }
    /**
     * @test
     */
    public function ignoreDuplicatedComponents()
    {
        $composite = $this->getComposite();
        $component1 = $this->getComposite();
        $composite->addComponent($component1);
        $composite->addComponent($component1);
        $composite->addComponent($component1);
        $expected = array($component1);
        $this->assertEquals($expected, $composite->getComponents());
    }
    /**
     * @test
     */
    public function storeExecutor()
    {
        $harvester = $this->getComposite();
        $this->assertSame($this->executor, $harvester->getExecutor());
    }
    /**
     * @test
     */
    public function useCustomExecutorWhenPassedWhileGettingOne()
    {
        $newExecutor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\Executor');
        $harvester = $this->getComposite();
        $this->assertSame($newExecutor, $harvester->getExecutor($newExecutor));
    }
}
