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
            'candidates' => 'modified'
        ));

        $this->assertSame(array('foo'), $config->getSuccessMessage());
        $this->assertSame(array('bar'), $config->getFailureMessage());
        $this->assertSame(array('baz'), $config->getBlacklist());
        $this->assertSame('modified', $config->getCandidates());
    }
    /**
     * @test
     */
    public function storeGroupConfiguration()
    {
        $groupParameters = array('foo' => array('files' => array('bar.js'), 'tools' => array('baz ####')));

        $config = $this->inputHelper->prepareWithGroupsConfiguration($groupParameters);

        $this->assertSame($groupParameters, $config->getGroups());
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
        unset($input['config']['candidates']);

        $config = new Config($input);

        $this->assertSame(array('-----------------', 'Validation passed', '-----------------'), $config->getSuccessMessage());
        $this->assertSame(array('-----------------', 'Validation failed', '-----------------'), $config->getFailureMessage());
        $this->assertSame(array(), $config->getBlacklist());
        $this->assertSame('staged', $config->getCandidates());

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
    /**
     * @test
     */
    public function throwExceptionIfWrongCandidatesParameterPassed()
    {
        $this->setExpectedException('InvalidArgumentException', 'candidates');
        $this->inputHelper->createConfig(array(
            'candidates' => 'wrongvalue'
        ));
    }
    /**
     * @test
     */
    public function allowCreationOfConfigWhenCorrectCandidatesParameter()
    {
        $this->inputHelper->createConfig(array(
            'candidates' => 'staged'
        ));
        $this->inputHelper->createConfig(array(
            'candidates' => 'modified'
        ));
    }

    private $inputHelper;
    public function setUp()
    {
        $this->inputHelper = new ConfigInputHelperTest();
    }


}