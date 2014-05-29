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
        $config = $this->inputHelper->createConfig(array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'stdout' => function() {},
            'blacklist' => array('baz'),
        ));

        $this->assertSame(array('foo'), $config->getSuccessMessage());
        $this->assertSame(array('bar'), $config->getFailureMessage());
        $this->assertSame(array('baz'), $config->getBlacklist());
    }
    /**
     * @test
     */
    public function providAccessForManyElementsArray()
    {
        $config = $this->inputHelper->createConfig(array(
            'success' => array('All OK', 'You can commit now'),
            'failure' => array('Validation failed', 'Correct mistakes'),
            'stdout' => function() {},
            'blacklist' => array('/*.class$/', '|^build/|'),
        ));

        $this->assertSame(array('All OK', 'You can commit now'), $config->getSuccessMessage());
        $this->assertSame(array('Validation failed', 'Correct mistakes'), $config->getFailureMessage());
        $this->assertSame(array('/*.class$/', '|^build/|'), $config->getBlacklist());
    }
    /**
     * @test
     */
    public function provideDefaultValuesIfFieldsNotConfigured()
    {
        $input = $this->inputHelper->prepare(array());
        unset($input['config']['success']);
        unset($input['config']['failure']);
        unset($input['config']['blacklist']);

        $config = new Config($input);

        $this->assertSame(array('-----------------', 'Validation passed', '-----------------'), $config->getSuccessMessage());
        $this->assertSame(array('-----------------', 'Validation failed', '-----------------'), $config->getFailureMessage());
        $this->assertSame(array(), $config->getBlacklist());

    }

    /**
     * @test
     */
    public function provideStdoutFunctionToDisplayMessages()
    {
        $config = $this->inputHelper->createConfig(array('stdout' =>
            function($msg) { echo "@@@{$msg}@@@"; }
        ));
        $stdOutFunction = $config->getStdout();

        $stdOutFunction('foo');

        $this->expectOutputString('@@@foo@@@');
    }

    /**
     * @test
     */
    public function provideStdoutFunctionToDisplayMessagesIfNoStdoutFunctionPassed()
    {

        $input = $this->inputHelper->prepare(array());
        unset($input['config']['stdout']);

        $config = new Config($input);
        $stdOutFunction = $config->getStdout();

        $stdOutFunction('bar');

        $this->expectOutputString('bar');
    }

    private $inputHelper;
    public function setUp()
    {
        $this->inputHelper = new ConfigInputHelperTest();
    }


}