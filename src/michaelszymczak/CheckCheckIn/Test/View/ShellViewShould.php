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
        $this->assertSame("\033[1;37m\033[41mSome error message\033[0m", $this->view->error('Some error message'));
        $this->assertSame("\033[1;37m\033[41m   \033[0m", $this->view->error('   '));
    }

    /**
     * @test
     */
    public function useMeaningfulColorsWhenInfoRendered()
    {
        $this->assertSame("\033[0;37mSome info message\033[0m", $this->view->info('Some info message'));
        $this->assertSame("\033[0;37m   \033[0m", $this->view->info('   '));
    }

    /**
     * @test
     */
    public function useMeaningfulColorsWhenSuccessRendered()
    {
        $this->assertSame("\033[1;37m\033[42mSome success message\033[0m", $this->view->success('Some success message'));
        $this->assertSame("\033[1;37m\033[42m   \033[0m", $this->view->success('   '));
    }
    /**
     * @test
     */
    public function returnTheSameMessageWithoutAnyColorsWhenRawRendered()
    {
        $this->assertSame('Some message', $this->view->raw('Some message'));
        $this->assertSame('', $this->view->raw(''));
    }

    /**
     * @test
     */
    public function returnEachMessageInlineIfExplicitlyConfiguredSoDuringCreation()
    {
        $view = new ShellView(new ColorfulShell(), ShellView::INLINE);
        $this->assertStringStartsNotWith("\n", $view->raw('foo'));
        $this->assertStringStartsNotWith("\n", $view->success('foo'));
        $this->assertStringStartsNotWith("\n", $view->info('foo'));
        $this->assertStringStartsNotWith("\n", $view->error('foo'));
    }

    /**
     * @test
     */
    public function returnEachMessageInNewlineByDefault()
    {
        $view = new ShellView(new ColorfulShell());
        $this->assertStringStartsWith("\n", $view->raw('foo'));
        $this->assertStringStartsWith("\n", $view->success('foo'));
        $this->assertStringStartsWith("\n", $view->info('foo'));
        $this->assertStringStartsWith("\n", $view->error('foo'));
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
