<?php
namespace michaelszymczak\CheckCheckIn\Test\Command;
use \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester;
use \michaelszymczak\CheckCheckIn\Command\CommandUniqueResultsComposite;
use \michaelszymczak\CheckCheckIn\Command\Git\GitModified;
use \michaelszymczak\CheckCheckIn\Command\Git\GitStaged;
use \Mockery as m;
/**
 * @covers \michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvester
 *
 */
class GitFilesHarvesterShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createHarvesterListingStagingFiles()
    {
        $harvester = $this->builder->toBeCommited();
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\CommandUniqueResultsComposite', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(1, $subharvesters);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitStaged', array_pop($subharvesters));
    }
    /**
     * @test
     */
    public function createHarvesterListingAllModifiedFilesRegardlessOfTheirCurrentState()
    {
        $harvester = $this->builder->allCandidates();
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\CommandUniqueResultsComposite', $harvester);
        $subharvesters = $harvester->getComponents();
        $this->assertCount(3, $subharvesters);
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitStaged', array_pop($subharvesters));
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitModified', array_pop($subharvesters));
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Command\Git\GitUntracked', array_pop($subharvesters));
    }

    /**
     * @test
     */
    public function injectItsExecutorWhileCreatingHarvesters()
    {
        $harvester = $this->builder->toBeCommited();
        $this->assertSame($this->executor, $harvester->getExecutor());
    }


    private $builder;
    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\Executor');
        $this->builder = new GitFilesHarvester($this->executor);
    }
}

