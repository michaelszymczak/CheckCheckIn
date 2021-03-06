<?php
namespace michaelszymczak\CheckCheckIn\Test\Response;
use \michaelszymczak\CheckCheckIn\Response\InfoResponse;

/**
 * @covers \michaelszymczak\CheckCheckIn\Response\InfoResponse
 * @covers \michaelszymczak\CheckCheckIn\Response\Response
 *
 */
class InfoResponseShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function beResponse()
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Response\Response', new InfoResponse('foo'));
    }
    /**
     * @test
     */
    public function renderItselfUsingInfoModeOfPassedRenderer()
    {
        $response = new InfoResponse(array('foo'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'info' => function($message) {
                    return "Info message: {$message[0]}";
                }
        ));

        $this->assertSame('Info message: foo', $response->render($renderer));
    }
    /**
     * @test
     */
    public function renderItselfUsingInfoModeOfPassedRenderer2()
    {
        $response = new InfoResponse(array('bar'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'info' => function($message) {
                    return "<info>{$message[0]}</info>";
                }
        ));

        $this->assertSame('<info>bar</info>', $response->render($renderer));
    }
}
