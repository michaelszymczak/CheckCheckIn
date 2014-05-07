<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils\Harvester;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\HarvesterBuilder;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf;
use \michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf;
use \Mockery as m;
/**
 * @covers \michaelszymczak\CheckCheckIn\Utils\Harvester\HarvesterBuilder
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
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(1, $subharvesters);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf', array_pop($subharvesters));
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
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(1, $subharvesters);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf', array_pop($subharvesters));
    }
    /**
     * @test
     */
    public function createHarvesterListingModifiedOrStagedFiles()
    {
        $harvester = $this->builder->buildGitModifiedAndStaged();
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\FilesHarvester', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(2, $subharvesters);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\GitStagedLeaf', array_pop($subharvesters));
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Utils\Harvester\GitModifiedLeaf', array_pop($subharvesters));
    }



    private $builder;
    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Utils\Executor\Executor');
        $this->builder = new HarvesterBuilder($this->executor);
    }
}

