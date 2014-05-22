<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use \michaelszymczak\CheckCheckIn\View\ShellView;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\InlineShellView
 *
 */
class InlineShellViewShould extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function returnMessageInline()
    {
        $this->assertSame("foo", $this->view->raw(array('foo')));
    }

    /**
     * @test
     */
    public function returnMessagesSeparatedBySpace()
    {
        $this->assertSame("foo bar", $this->view->raw(array('foo', 'bar')));
    }

    /**
     * @test
     */
    public function putSpaceBetweenEachColorMessage()
    {
        $this->assertSame("\033[1;37m\033[41mfoo\033[0m \033[1;37m\033[41mbar\033[0m", $this->view->error(array('foo', 'bar')));
    }


    private $view;

    public function setUp()
    {
        $this->view = ShellView::createInline();
    }
}