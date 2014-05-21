<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use \michaelszymczak\CheckCheckIn\View\ColorfulShell;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\ColorfulShell
 *
 */
class ColorfulShellShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnTheSameStringWhenNoColorsPassed()
    {
        $this->assertSame('foo', $this->colorfulShell->colorize('foo'));
    }
    /**
     * @test
     */
    public function returnColoredStringWhenForegroundColorPassed()
    {
        $this->assertSame("\033[0;34mfoo\033[0m", $this->colorfulShell->colorize('foo', ColorfulShell::BLUE_FG));
    }
    /**
     * @test
     */
    public function returnColoredStringAndBackgroundWhenBothForegroundAndBackgroundColorsPassed()
    {
        $this->assertSame("\033[1;37m\033[42mfoo\033[0m", $this->colorfulShell->colorize('foo', ColorfulShell::WHITE_FG, ColorfulShell::GREEN_BG));
    }
    /**
     * @test
     */
    public function allowPassingCustomColorCodes()
    {
        $this->assertSame("\033[0;35mfoo\033[0m", $this->colorfulShell->colorize('foo', '0;35'));
    }

    private $colorfulShell;

    public function setUp()
    {
        $this->colorfulShell = new ColorfulShell();
    }
}
