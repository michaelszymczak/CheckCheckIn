<?php
namespace michaelszymczak\CheckCheckIn\Test\Configuration;

use \michaelszymczak\CheckCheckIn\Configuration\DependencyManager;

/**
 * @covers \michaelszymczak\CheckCheckIn\Configuration\DependencyManager
 *
 */
class DependencyManagerShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createDisplayUsingStdoutFunctionFromConfig()
    {
        $config = $this->inputHelper->createConfig(array('stdout' =>
            function($msg) { echo "FROM CONFIG: {$msg}"; }
        ));
        $manager = new DependencyManager($config);

        $manager->getDisplay()->display('foo');

        $this->expectOutputString('FROM CONFIG: foo');
    }

    /**
     * @test
     */
    public function createGroupBasedOnGroupParameters()
    {

        $config = $this->inputHelper->prepareWithGroupsConfiguration(array(
            'groupFoo' => array(
                'files' => array('/*.foo$/'),
                'tools' => array('fooCheck ####')
            ),
            'groupBar' => array(
                'files' => array('/*.bar$/'),
                'tools' => array('barCheck ####')
            )
        ));
        $manager = new DependencyManager($config);

        $groups = $manager->getGroups();

        $this->assertCreatedGroupsWithConfiguration(array(
                array('filePatterns' => array('/*.foo$/'), 'toolPatterns' => array('fooCheck ####')),
                array('filePatterns' => array('/*.bar$/'), 'toolPatterns' => array('barCheck ####')),
            ),
            $groups
        );
    }


    private function assertCreatedGroupsWithConfiguration($configuration, $groups)
    {
        foreach ($configuration as $key => $properties) {
            $this->assertSame($properties['filePatterns'], $groups[$key]->getFilePatterns());
            $this->assertSame($properties['toolPatterns'], $groups[$key]->getToolPatterns());
        }
    }

    private $inputHelper;
    public function setUp()
    {
        $this->inputHelper = new ConfigInputHelperTest();
    }
}