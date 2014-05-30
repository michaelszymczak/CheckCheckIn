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
        $manager = $this->createDMWithConfigParams(array('stdout' =>
            function ($msg) {
                echo "FROM CONFIG: {$msg}";
            }
        ));

        $manager->getDisplay()->display('foo');

        $this->expectOutputString('FROM CONFIG: foo');
    }

    /**
     * @test
     */
    public function createGroupBasedOnGroupParameters()
    {

        $manager = $this->createDMWithConfigParams(array(), array(
            'groupFoo' => array(
                'files' => array('/*.foo$/'),
                'tools' => array('fooCheck ####')
            ),
            'groupBar' => array(
                'files' => array('/*.bar$/'),
                'tools' => array('barCheck ####')
            )
        ));

        $groups = $manager->getGroups();

        $this->assertCreatedGroupsWithConfiguration(array(
                array('filePatterns' => array('/*.foo$/'), 'toolPatterns' => array('fooCheck ####')),
                array('filePatterns' => array('/*.bar$/'), 'toolPatterns' => array('barCheck ####')),
            ),
            $groups
        );
    }

    /**
     * @test
     *
     * @covers \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever::getBlacklist
     */
    public function createFilteredGitFilesRetrieverUsingConfigBlacklist()
    {
        $manager = $this->createDMWithConfigParams(array('blacklist' => array('/foo/')));

        $retriever = $manager->getFilteredGitFilesRetriever();

        $this->assertSame(array('/foo/'), $retriever->getBlacklist());
    }
    /**
     * @test
     *
     * @covers \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever::getBlacklist
     */
    public function createFilteredGitFilesRetrieverWithGitStagedFilesHarvesterWhenStagedCandidatesInConfig()
    {
        $manager = $this->createDMWithConfigParams(array('candidates' => 'staged'));

        $retriever = $manager->getFilteredGitFilesRetriever();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitStagedFilesHarvester', $retriever->getHarvester());
    }
    /**
     * @test
     *
     * @covers \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever::getBlacklist
     */
    public function createFilteredGitFilesRetrieverWithGitModifiedFilesHarvesterWhenModifiedCandidatesInConfig()
    {
        $manager = $this->createDMWithConfigParams(array('candidates' => 'modified'));

        $retriever = $manager->getFilteredGitFilesRetriever();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitModifiedFilesHarvester', $retriever->getHarvester());
    }
    /**
     * @test
     *
     * @covers \michaelszymczak\CheckCheckIn\Validator\ValidatorFactory::getManager
     */
    public function createValidatorFactory()
    {
        $manager = $this->createDMWithConfigParams(array('candidates' => 'modified'));

        $validatorFactory = $manager->getValidatorFactory();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Validator\ValidatorFactory', $validatorFactory);
        $this->assertSame($manager, $validatorFactory->getManager());
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

    private function createDMWithConfigParams($config = array(), $groups = array())
    {
        $config = $this->inputHelper->createConfig($config, $groups);
        $manager = new DependencyManager($config);
        return $manager;
    }
}