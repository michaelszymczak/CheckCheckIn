<?php
namespace michaelszymczak\CheckCheckIn\Test\Configuration;

use \michaelszymczak\CheckCheckIn\Configuration\Config;

/**
 * @covers \michaelszymczak\CheckCheckIn\Configuration\Config
 *
 */
class ConfigShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function providAccessForData()
    {
        $input = array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'stdout' => function() {},
            'blacklist' => array('baz'),
        );

        $config = new Config($input);

        $this->assertSame(array('foo'), $config->getSuccessMessage());
        $this->assertSame(array('bar'), $config->getFailureMessage());
        $this->assertSame(array('baz'), $config->getBlacklist());
    }
    /**
     * @test
     */
    public function providAccessForManyElementsArray()
    {
        $input = array(
            'success' => array('All OK', 'You can commit now'),
            'failure' => array('Validation failed', 'Correct mistakes'),
            'stdout' => function() {},
            'blacklist' => array('/*.class$/', '|^build/|'),
        );

        $config = new Config($input);

        $this->assertSame(array('All OK', 'You can commit now'), $config->getSuccessMessage());
        $this->assertSame(array('Validation failed', 'Correct mistakes'), $config->getFailureMessage());
        $this->assertSame(array('/*.class$/', '|^build/|'), $config->getBlacklist());
    }
    /**
     * @test
     */
    public function provideDefaultValuesIfFieldsNotConfigured()
    {
        $config = new Config(array());

        $this->assertSame(array('-----------------', 'Validation passed', '-----------------'), $config->getSuccessMessage());
        $this->assertSame(array('-----------------', 'Validation failed', '-----------------'), $config->getFailureMessage());
        $this->assertSame(array(), $config->getBlacklist());

    }

    /**
     * @test
     */
    public function useStdoutFunctionFromInputToProcessDisplaying()
    {
        $config = new Config(array('stdout' =>
            function($msg) { echo "@@@{$msg}@@@"; }
        ));

        $config->stdout('foo');

        $this->expectOutputString('@@@foo@@@');
    }

    /**
     * @test
     */
    public function useDefaultEchoFunctionIfNoStdoutFunctionPassedInInputParameters()
    {
        $config = new Config(array());

        $config->stdout('bar');

        $this->expectOutputString('bar');

    }

}