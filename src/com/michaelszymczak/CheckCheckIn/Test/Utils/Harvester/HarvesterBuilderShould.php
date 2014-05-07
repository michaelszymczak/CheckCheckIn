<?php
namespace com\michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use \com\michaelszymczak\CheckCheckIn\Utils\Harvester\HarvesterBuilder;
use \com\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester;
use \com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf;
use \com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf;
use \Mockery as m;
/**
 * @covers \com\michaelszymczak\CheckCheckIn\Utils\Harvester\HarvesterBuilder
 *
 */
class HarvesterBuilderShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createHarvesterListingStagingFiles()
    {
        $harvester = $this->builder->buildGitStaged();
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(1, $subharvesters);
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf', array_pop($subharvesters));
    }
    /**
     * @test
     */
    public function injectItsExecutorWhileCreatingHarvesters()
    {
        $harvester = $this->builder->buildGitStaged();
        $this->assertSame($this->executor, $harvester->getExecutor());
    }
    /**
     * @test
     */
    public function createHarvesterListingModifiedFiles()
    {
        $harvester = $this->builder->buildGitModified();
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(1, $subharvesters);
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf', array_pop($subharvesters));
    }
    /**
     * @test
     */
    public function createHarvesterListingModifiedOrStagedFiles()
    {
        $harvester = $this->builder->buildGitModifiedAndStaged();
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(2, $subharvesters);
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf', array_pop($subharvesters));
        $this->assertInstanceOf('\com\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf', array_pop($subharvesters));
    }



    private $builder;
    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\com\michaelszymczak\CheckCheckIn\Utils\Executor\Executor');
        $this->builder = new HarvesterBuilder($this->executor);
    }
}

