<?php
namespace michaelszymczak\CheckCheckIn\Test\Configuration;

use \michaelszymczak\CheckCheckIn\Configuration\Group;

/**
 * @covers \michaelszymczak\CheckCheckIn\Configuration\Group
 *
 */
class GroupShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function provideProcessedFilePatterns()
    {
        $this->params['files'] = array('/\.java$/');

        $group = new Group($this->params);

        $this->assertSame(
            array('/\.java$/'),
            $group->getFilePatterns()
        );
    }
    /**
     * @test
     */
    public function provideToolPatternsUsedToProcessFiles()
    {
        $this->params['tools'] = array('findbugs' => 'java -jar $FINDBUGS_HOME/lib/findbugs.jar #### -Dsomeoption');

        $group = new Group($this->params);

        $this->assertSame(
            array('findbugs' => 'java -jar $FINDBUGS_HOME/lib/findbugs.jar #### -Dsomeoption'),
            $group->getToolPatterns()
        );
    }
    /**
     * @test
     */
    public function throwExceptionIfNoFilePatternsProvided()
    {
        $this->setExpectedException('InvalidArgumentException', 'files');
        unset($this->params['files']);

        new Group($this->params);
    }
    /**
     * @test
     */
    public function throwExceptionIfNoToolPatternsProvided()
    {
        $this->setExpectedException('InvalidArgumentException', 'tools');
        unset($this->params['tools']);

        new Group($this->params);
    }

    private $params;
    public function setUp()
    {
        $this->params = array(
          'files' => array('foo'),
          'tools' => array('bar')
        );
    }
}