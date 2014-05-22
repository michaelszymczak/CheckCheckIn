<?php
namespace michaelszymczak\CheckCheckIn\Test\Response;
use \michaelszymczak\CheckCheckIn\Response\SuccessResponse;

/**
 * @covers \michaelszymczak\CheckCheckIn\Response\SuccessResponse
 * @covers \michaelszymczak\CheckCheckIn\Response\Response
 *
 */
class SuccessResponseShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function beResponse()
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Response\Response', new SuccessResponse('foo'));
    }
    /**
     * @test
     */
    public function renderItselfUsingSuccessModeOfPassedRenderer()
    {
        $response = new SuccessResponse(array('foo'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'success' => function($message) {
                    return "Success message: {$message[0]}";
                }
        ));

        $this->assertSame('Success message: foo', $response->render($renderer));
    }
    /**
     * @test
     */
    public function renderItselfUsingSuccessModeOfPassedRenderer2()
    {
        $response = new SuccessResponse(array('bar'));

        $renderer = new DummyRendererTest();
        $renderer->expect(array(
            'success' => function($message) {
                    return "<success>{$message[0]}</success>";
                }
        ));

        $this->assertSame('<success>bar</success>', $response->render($renderer));
    }
}
