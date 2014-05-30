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
        $display = new Display(
            $this->prepareConfig( array('stdout' => function($msg) { echo "Stdout function displays: {$msg}"; }))
        );

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
    }

    private function createDisplayWithConfiguredMessage($params)
    {
        $params['stdout'] = function ($msg) { echo $msg; };
        $config = $this->prepareConfig($params);
        $display = new Display($config);

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

    private function prepareConfig($config = array(), $groups = array())
    {
        $defaultConfig = array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'blacklist' => array('baz'),
        );

        foreach($config as $key => $value) {
            $defaultConfig[$key] = $value;
        }

        return new Config(array(
            'config' => $defaultConfig,
            'groups' => $groups
        ));
    }
}
