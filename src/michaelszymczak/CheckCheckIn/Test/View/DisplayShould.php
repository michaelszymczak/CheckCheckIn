<?php
namespace michaelszymczak\CheckCheckIn\Test\View;

use \michaelszymczak\CheckCheckIn\View\Display;
use \michaelszymczak\CheckCheckIn\Configuration\Config;

/**
 * @covers \michaelszymczak\CheckCheckIn\View\Display
 *
 */
class DisplayShould extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function displayMessageUsingConfigStdoutFunction()
    {
        $display = new Display(new Config(
            array('stdout' => function($msg) { echo "Stdout function displays: {$msg}"; })
        ));

        $display->display('foo');

        $this->expectOutputString("Stdout function displays: foo");
    }

    /**
     * @test
     */
    public function displayFailureAsFinalVerdictWhenValidationFailed()
    {
        $display = $this->createDisplayWithConfiguredMessage(array('failure' => 'FAILURE'));

        $display->displayFinalVerdict(false);

        $this->expectFailureResponseContaining('FAILURE');
    }
    /**
     * @test
     */
    public function displaySuccessAsFinalVerdictWhenValidationPassed()
    {
        $display = $this->createDisplayWithConfiguredMessage(array('success' => 'SUCCESS'));

        $display->displayFinalVerdict(true);

        $this->expectSuccessResponseContaining('SUCCESS');
    }


    public function setUp()
    {
        $config = new Config(array());
        $this->display = new Display($config);
    }

    private function createDisplayWithConfiguredMessage($params)
    {
        $params['stdout'] = function ($msg) { echo $msg; };
        $display = new Display(new Config($params));

        return $display;
    }

    private function expectSuccessResponseContaining($message)
    {
        $this->expectOutputString("\n\033[1;37m\033[42m{$message}\033[0m");
    }
    private function expectFailureResponseContaining($message)
    {
        $this->expectOutputString("\n\033[1;37m\033[41m{$message}\033[0m");
    }
}
