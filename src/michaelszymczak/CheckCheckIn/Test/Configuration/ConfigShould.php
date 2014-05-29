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
        $input = $this->prepareConfigInput(array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'stdout' => function() {},
            'blacklist' => array('baz'),
        ));

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
        $input = $this->prepareConfigInput(array(
            'success' => array('All OK', 'You can commit now'),
            'failure' => array('Validation failed', 'Correct mistakes'),
            'stdout' => function() {},
            'blacklist' => array('/*.class$/', '|^build/|'),
        ));

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
        $input = $this->prepareConfigInput(array());
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
        $input = $this->prepareConfigInput(array('stdout' =>
            function($msg) { echo "@@@{$msg}@@@"; }
        ));
        $config = new Config($input);
        $stdOutFunction = $config->getStdout();

        $stdOutFunction('foo');

        $this->expectOutputString('@@@foo@@@');
    }

    /**
     * @test
     */
    public function provideStdoutFunctionToDisplayMessagesIfNoStdoutFunctionPassed()
    {

        $input = $this->prepareConfigInput(array());
        unset($input['config']['stdout']);

        $config = new Config($input);
        $stdOutFunction = $config->getStdout();

        $stdOutFunction('bar');

        $this->expectOutputString('bar');
    }

    /**
     * @test
     */
    public function createGroupBasedOnGroupParameters()
    {
        $config = $this->prepareConfigWithGroupsConfiguration(array(
            'groupFoo' => array(
                'files' => array('/*.foo$/'),
                'tools' => array('fooCheck ####')
            ),
            'groupBar' => array(
                'files' => array('/*.bar$/'),
                'tools' => array('barCheck ####')
            )
        ));

        $groups = $config->getGroups();

        $this->assertCreatedGroupsWithConfiguration(array(
                array('filePatterns' => array('/*.foo$/'), 'toolPatterns' => array('fooCheck ####')),
                array('filePatterns' => array('/*.bar$/'), 'toolPatterns' => array('barCheck ####')),
            ),
            $groups
        );
    }
    /**
     * @test
     */
    public function createDisplayUsingThisConfig()
    {
        $input = $this->prepareConfigInput(array('stdout' =>
            function($msg) { echo "FROM CONFIG: {$msg}"; }
        ));
        $config = new Config($input);

        $config->getDisplay()->display('foo');

        $this->expectOutputString('FROM CONFIG: foo');
    }


    private function prepareConfigInput($config = array(), $groups = array())
    {
        $defaultConfig = array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'blacklist' => array('baz'),
        );

        foreach($config as $key => $value) {
            $defaultConfig[$key] = $value;
        }

        return array(
            'config' => $defaultConfig,
            'groups' => $groups
        );
    }

    private function prepareConfigWithGroupsConfiguration($groupConfiguration)
    {
        $input = $this->prepareConfigInput(array(), $groupConfiguration);
        $config = new Config($input);

        return $config;
    }

    private function assertCreatedGroupsWithConfiguration($configuration, $groups)
    {
        foreach ($configuration as $key => $properties) {
            $this->assertSame($properties['filePatterns'], $groups[$key]->getFilePatterns());
            $this->assertSame($properties['toolPatterns'], $groups[$key]->getToolPatterns());
        }
    }


}