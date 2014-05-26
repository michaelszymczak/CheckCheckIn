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
        $executor = $this->getExecutor();
        $executor->shouldReceive('exec')->with('foo some/path/file.js bar')->once();

        $validator = new Validator($executor, array('validatorA' => 'foo #### bar'));

        $validator->validate('some/path/file.js');
    }
    /**
     * @test
     */
    public function validatePassedFileAgainstAllValidators()
    {
        $executor = $this->getExecutor();
        $executor->shouldReceive('exec')->with('tool1 Bar.java')->once();
        $executor->shouldReceive('exec')->with('tool2 Bar.java -Dsomeoption')->once();

        $validator = new Validator($executor, array('validator1' => 'tool1 ####', 'validator2' => 'tool2 #### -Dsomeoption'));

        $validator->validate('Bar.java');
    }
    /**
     * @test
     */
    public function notHaveAnyResponsesUponConstruction()
    {
        $validator = new Validator($this->getExecutor(), array('tool' => 'tool ####'));

        $this->assertNoResponses($validator);
    }
    /**
     * @test
     */
    public function afterValidationreturnResponseWithFileNameAsFirstStatusResponse()
    {
        $this->validator->validate('Foo.java');

        $this->assertFirstStatusResponseEquals('=> Foo.java: ', $this->validator);
    }
    /**
     * @test
     */
    public function mentionToolUsedToValidateCorrectFile()
    {
        $this->validator->validate('Good.java');

        $this->assertValidatorHasOneToolMentionedInStatus($this->validator);
    }
    /**
     * @test
     */
    public function notContainValidationDetailsWhenWalidationPassed()
    {
        $this->validator->validate('Good.java');

        $this->assertValidatorHasNoViolationsReported($this->validator);
    }
    /**
     * @test
     */
    public function mentionToolUsedToValidateFileWithViolations()
    {
        $this->validator->validate('Bad.java');

        $this->assertValidatorHasOneToolMentionedInStatus($this->validator);
    }
    /**
     * @test
     */
    public function containValidationDetailsWhenWalidationFailed()
    {
        $this->validator->validate('Bad.java');

        $this->assertValidatorHasOneDescribedViolation($this->validator);
    }
    /**
     * @test
     */
    public function clearStatusesAndViolationResponsesBeforeEachValidation()
    {
        $this->validator->validate('Good.java');
        $this->validator->validate('Bad.java');
        $this->validator->validate('Bad.java');

        $this->assertValidatorHasOneToolMentionedInStatus($this->validator);
        $this->assertValidatorHasOneDescribedViolation($this->validator);
    }
    /**
     * @test
     */
    public function reportThatFilesAreValidIUponConstruction()
    {
        $this->assertTrue($this->validator->areValid());
    }
    /**
     * @test
     */
    public function reportThatFilesAreValidIfValidFileValidated()
    {
        $this->validator->validate('Good.java');

        $this->assertTrue($this->validator->areValid());
    }
    /**
     * @test
     */
    public function reportThatFilesAreInvalidIfAtLeastOneFileInvalid()
    {
        $this->validator->validate('Good.java');
        $this->validator->validate('Bad.java');
        $this->validator->validate('Good.java');

        $this->assertFalse($this->validator->areValid());
    }

    private $executor;
    public function setUp()
    {
        $this->executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor');
        $this->validator = new Validator($this->getExecutor(), array('tool name' => 'tool ####'));
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

    private function getExecutor()
    {
        $executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor');
        $executor->shouldReceive('exec')->with('tool Foo.java')->andReturn(array());
        $executor->shouldReceive('exec')->with('tool Good.java')->andReturn(array());
        $executor->shouldReceive('exec')->with('tool Bad.java')->andReturn(array('some violation', 'bbb'));

        return $executor;
    }

    private function assertFirstStatusResponseEquals($expectedMessage, $validator)
    {
        $statusResponses = $validator->getStatusResponses();
        $statusResponseWithFilename = $statusResponses[0];

        $message = $statusResponseWithFilename->getMessage();
        $this->assertSame($expectedMessage, $message[0]);
    }

    /**
     * @param $validator
     */
    private function assertValidatorHasOneToolMentionedInStatus($validator)
    {
        $this->assertCount(2, $validator->getStatusResponses());
    }
    /**
     * @param $validator
     */
    private function assertValidatorHasOneDescribedViolation($validator)
    {
        $this->assertCount(1, $validator->getViolationResponses());
    }

    private function assertValidatorHasNoViolationsReported($validator)
    {
        $this->assertCount(0, $validator->getViolationResponses());
    }


}