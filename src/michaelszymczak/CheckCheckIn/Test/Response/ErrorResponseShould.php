<?php
namespace michaelszymczak\CheckCheckIn\Test\Response;
use \michaelszymczak\CheckCheckIn\Response\ErrorResponse;

/**
 * @covers \michaelszymczak\CheckCheckIn\Response\ErrorResponse
 * @covers \michaelszymczak\CheckCheckIn\Response\Response
 *
 */
class ErrorResponseShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function beResponse()
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Response\Response', new ErrorResponse('foo'));
    }
    /**
     * @test
     */
    public function renderItselfUsingErrorModeOfPassedRenderer()
    {
        $response = new ErrorResponse(array('foo'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'error' => function($message) {
                    return "Error message: {$message[0]}";
                }
        ));

        $this->assertSame('Error message: foo', $response->render($renderer));
    }
    /**
     * @test
     */
    public function renderItselfUsingErrorModeOfPassedRenderer2()
    {
        $response = new ErrorResponse(array('bar'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'error' => function($message) {
                    return "<err>{$message[0]}</err>";
                }
        ));

        $this->assertSame('<err>bar</err>', $response->render($renderer));
    }
}
