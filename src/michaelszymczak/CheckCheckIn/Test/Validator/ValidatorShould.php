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

    /**
     * @test
     */
    public function clearStatusesAndViolationResponsesBeforeEachValidation()
    {
        $validator = new Validator($this->getViolationDetectedExecutor(), array('tool' => 'tool ####'));

        $this->assertNoResponses($validator);

        $validator->validate('Foo.java');

        $this->assertCount(2, $validator->getStatusResponses());
        $this->assertCount(1, $validator->getViolationResponses());

        $validator->validate('Bar.java');

        $this->assertCount(2, $validator->getStatusResponses());
        $this->assertCount(1, $validator->getViolationResponses());

    }

    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor');
    }

    public function tearDown()
    {
        m::close();
    }

    private function assertNoResponses($validator)
    {
        $this->assertEmpty($validator->getStatusResponses());
        $this->assertEmpty($validator->getViolationResponses());
    }

    private function getViolationDetectedExecutor()
    {
        $executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor');
        $executor->shouldReceive('exec')->andReturn(array('some violation', 'bbb'));

        return $executor;
    }




}