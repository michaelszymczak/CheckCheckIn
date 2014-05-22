<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use \michaelszymczak\CheckCheckIn\View\ShellView;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\NewlineShellView
 *
 */
class NewlineShellViewShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function putEachMessageInTheNewLine()
    {
        $this->assertSame("\nfoo\nbar", $this->view->raw(array('foo', 'bar')));
    }
    /**
     * @test
     */
    public function putNewLinesBetweenEachColorMessage()
    {
        $this->assertSame("\n\033[1;37m\033[41mfoo\033[0m\n\033[1;37m\033[41mbar\033[0m", $this->view->error(array('foo', 'bar')));
    }

    private $view;

    public function setUp()
    {
        $this->view = ShellView::createNewline();
    }
}