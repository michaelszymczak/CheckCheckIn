<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use \michaelszymczak\CheckCheckIn\View\ShellView;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\DefaultShellView
 *
 */
class DefaultShellViewShould extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function startFirstMessageInNewline()
    {
        $this->assertStringStartsWith("\n", $this->view->raw(array('foo')));
        $this->assertStringStartsWith("\n", $this->view->success(array('foo')));
        $this->assertStringStartsWith("\n", $this->view->info(array('foo')));
        $this->assertStringStartsWith("\n", $this->view->error(array('foo')));
    }
    /**
     * @test
     */
    public function putInTheNewLineOnlyFirstOfTheMessagesAndSeparateRestWithSpaces()
    {
        $this->assertSame("\nfoo bar", $this->view->raw(array('foo', 'bar')));
    }
    /**
     * @test
     */
    public function putSpaceBetweenEachColorMessage()
    {
        $this->assertSame("\n\033[1;37m\033[41mfoo\033[0m \033[1;37m\033[41mbar\033[0m", $this->view->error(array('foo', 'bar')));
    }

    private $view;

    public function setUp()
    {
        $this->view = ShellView::createDefault();
    }
}