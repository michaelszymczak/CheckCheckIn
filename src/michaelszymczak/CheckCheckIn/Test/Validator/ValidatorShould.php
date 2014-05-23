<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\Validator;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\Validator
 */
class ValidatorShould extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function runPassedCommandAgainstPassedExecutorInjectingFilePathIntoPattern()
    {
        $this->executor->shouldReceive('exec')->with('foo some/path/file.js bar')->once();

        $validator = new Validator($this->executor, array('validatorA' => 'foo #### bar'));
        $validator->validate('some/path/file.js');
    }
    /**
     * @test
     */
    public function validatePassedFileAgainstAllValidators()
    {
        $this->executor->shouldReceive('exec')->with('tool1 foo.java')->once();
        $this->executor->shouldReceive('exec')->with('tool2 foo.java -Dsomeoption')->once();

        $validator = new Validator($this->executor, array('validator1' => 'tool1 ####', 'validator2' => 'tool2 #### -Dsomeoption'));
        $validator->validate('foo.java');
    }
    /**
     * @test
     */
    public function returnResponseWithFileNameAsFirstStatusResponse()
    {
        $this->executor->shouldReceive('exec')->with('foo some/path/file.js bar');

        $validator = new Validator($this->executor, array('validatorA' => 'foo #### bar'));
        $validator->validate('some/path/file.js');

        $statusResponses = $validator->getStatusResponses();
        $statusResponseWithFilename = $statusResponses[0];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\Response', $statusResponseWithFilename);
        $this->assertSame(array('=> some/path/file.js: '), $statusResponseWithFilename->getMessage());
    }

    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsExecutor');
    }

    public function tearDown()
    {
        m::close();
    }


}