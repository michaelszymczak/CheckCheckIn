<?php
namespace michaelszymczak\CheckCheckIn\Test\Response;
use \michaelszymczak\CheckCheckIn\Response\Response;
use michaelszymczak\CheckCheckIn\Response\ResponseRenderer;

/**
 * @covers \michaelszymczak\CheckCheckIn\Response\Response
 *
 */
class ResponseShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returnMessagePassedDuringObjectCreation()
    {
        $response = new SampleResponse(array('foo'));

        $this->assertSame(array('foo'), $response->getMessage());
    }
    /**
     * @test
     */
    public function returnMoreThanOneMessagesPassedDuringObjectCreation()
    {
        $response = new SampleResponse(array('bar', 'bar', 'baz'));

        $this->assertSame(array('bar', 'bar', 'baz'), $response->getMessage());
    }
    /**
     * @test
     */
    public function transformStringIntoArrayContainingThisString()
    {
        $response = new SampleResponse('bar');

        $this->assertSame(array('bar'), $response->getMessage());
    }
}

/**
 * Simulation of private class used to test the Response class (PHP, as apposed to for example Java, does not have private classes).
 * I test non abstract methods only and avoid code duplication in the rest of the tests.
 */
class SampleResponse extends Response {

    public function render(ResponseRenderer $renderer)
    {
        return '';
    }
}