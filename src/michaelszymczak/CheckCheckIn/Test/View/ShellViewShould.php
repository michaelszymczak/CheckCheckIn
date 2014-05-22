<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use michaelszymczak\CheckCheckIn\View\ColorfulShell;
use \michaelszymczak\CheckCheckIn\View\ShellView;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\ShellView
 *
 */
class ShellViewShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function beAbleToBeInjectedWhereResponseRendererIsExpected()
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Response\ResponseRenderer', $this->view);
    }

    /**
     * @test
     */
    public function useMeaningfulColorsWhenErrorRendered()
    {
        $this->assertSame("\033[1;37m\033[41mSome error message\033[0m", $this->view->error(array('Some error message')));
        $this->assertSame("\033[1;37m\033[41m   \033[0m", $this->view->error(array('   ')));
    }

    /**
     * @test
     */
    public function useMeaningfulColorsWhenInfoRendered()
    {
        $this->assertSame("\033[0;37mSome info message\033[0m", $this->view->info(array('Some info message')));
        $this->assertSame("\033[0;37m   \033[0m", $this->view->info(array('   ')));
    }

    /**
     * @test
     */
    public function useMeaningfulColorsWhenSuccessRendered()
    {
        $this->assertSame("\033[1;37m\033[42mSome success message\033[0m", $this->view->success(array('Some success message')));
        $this->assertSame("\033[1;37m\033[42m   \033[0m", $this->view->success(array('   ')));
    }
    /**
     * @test
     */
    public function returnTheSameMessageWithoutAnyColorsWhenRawRendered()
    {
        $this->assertSame('Some message', $this->view->raw(array('Some message')));
        $this->assertSame('', $this->view->raw(array('')));
    }

    /**
     * @test
     */
    public function returnEachMessageInlineIfExplicitlyConfiguredSoDuringCreation()
    {
        $view = new ShellView(new ColorfulShell(), ShellView::INLINE);
        $this->assertStringStartsNotWith("\n", $view->raw(array('foo')));
        $this->assertStringStartsNotWith("\n", $view->success(array('foo')));
        $this->assertStringStartsNotWith("\n", $view->info(array('foo')));
        $this->assertStringStartsNotWith("\n", $view->error(array('foo')));
    }

    /**
     * @test
     */
    public function returnEachMessageInNewlineByDefault()
    {
        $view = new ShellView(new ColorfulShell());
        $this->assertStringStartsWith("\n", $view->raw(array('foo')));
        $this->assertStringStartsWith("\n", $view->success(array('foo')));
        $this->assertStringStartsWith("\n", $view->info(array('foo')));
        $this->assertStringStartsWith("\n", $view->error(array('foo')));
    }


    /**
     * @var \michaelszymczak\CheckCheckIn\View\ShellView
     */
    private $view;
    public function setUp()
    {
        $this->view = new ShellView(new ColorfulShell(), ShellView::INLINE);
    }
}
