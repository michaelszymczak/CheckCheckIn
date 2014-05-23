<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;

use \michaelszymczak\CheckCheckIn\Command\CustomCommand;

/**
 * Class CustomCommandShould.
 *
 * @covers \michaelszymczak\CheckCheckIn\Command\CustomCommand
 * @covers \michaelszymczak\CheckCheckIn\Command\ExecutorAwareComponent
 */
class CustomCommandShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function runCommandPassedInConstructor()
    {
        $commandFoo = new CustomCommand('foo');
        $commandBar = new CustomCommand('bar');

        $this->assertSame(array('foo'), $commandFoo->getCommands());
        $this->assertSame(array('bar'), $commandBar->getCommands());

    }

}
