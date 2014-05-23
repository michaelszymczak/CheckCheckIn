<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\Validator;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\Validator
 */
class ValidatorWhenValidationPassedShould extends \PHPUnit_Framework_TestCase
{
    const FILE_TO_CHECK = 'foo.js';

    /**
     * @test
     */
    public function returnTrueAfterValidation()
    {
        $this->assertTrue($this->validator->validate(self::FILE_TO_CHECK));
    }
    /**
     * @test
     */
    public function returnSuccessResponseWithFileName()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseWithFilename = $statusResponses[0];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\SuccessResponse', $statusResponseWithFilename);
        $this->assertSame(array('=> '. self::FILE_TO_CHECK .': '), $statusResponseWithFilename->getMessage());
    }
    /**
     * @test
     */
    public function returnInfoResponseWithPassedValidationAgainstUsedTool()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseWithUsedTool = $statusResponses[1];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseWithUsedTool);
        $this->assertSame(array('validatorFoo [PASSED]'), $statusResponseWithUsedTool->getMessage());
    }

    /**
     * @test
     */
    public function returnInfoResponseContainingAllUsedTools()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseWithUsedTool = $statusResponses[2];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseWithUsedTool);
        $this->assertSame(array('validatorBar [PASSED]'), $statusResponseWithUsedTool->getMessage());
    }

    private $validator;

    public function setUp()
    {
        $executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsExecutor');
        $executor->shouldReceive('exec')->with('check ' . self::FILE_TO_CHECK)->andReturn(array());
        $executor->shouldReceive('exec')->with('check2 ' . self::FILE_TO_CHECK)->andReturn(array());

        $this->validator = new Validator($executor, array('validatorFoo' => 'check ####', 'validatorBar' => 'check2 ####'));
    }

    public function tearDown()
    {
        m::close();
    }


}