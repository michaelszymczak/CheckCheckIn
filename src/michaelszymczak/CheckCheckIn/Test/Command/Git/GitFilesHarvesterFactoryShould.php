<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
use \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvesterFactory;

use \Mockery as m;
/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvesterFactory
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester
 *
 */
class GitFilesHarvesterFactoryShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createGitModifiedFilesHarvesterWithStrictExecutor()
    {
        $harvester = $this->factory->createForModified();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitModifiedFilesHarvester', $harvester);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Executor\StrictExecutor', $harvester->getExecutor());
    }
    /**
     * @test
     */
    public function createGitStagedFilesHarvesterWithStrictExecutor()
    {
        $harvester = $this->factory->createForStaged();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitStagedFilesHarvester', $harvester);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Executor\StrictExecutor', $harvester->getExecutor());
    }

    private $factory;
    public function setUp()
    {
        $this->factory = new GitFilesHarvesterFactory();
    }
}

