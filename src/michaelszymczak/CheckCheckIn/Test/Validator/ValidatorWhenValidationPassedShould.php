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
    public function returnInfoResponseAboutToolsUsed()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseOfFirstTool = $statusResponses[1];
        $statusResponseOfSecondTool = $statusResponses[2];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseOfFirstTool);
        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseOfSecondTool);
        $this->assertSame(array('validatorFoo [PASSED]'), $statusResponseOfFirstTool->getMessage());
        $this->assertSame(array('validatorBar [PASSED]'), $statusResponseOfSecondTool->getMessage());
    }
    /**
     * @test
     */
    public function returnNotInformationAboutViolation()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $this->assertEmpty($this->validator->getViolationResponses());
    }

    private $validator;

    public function setUp()
    {
        $executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor');
        $executor->shouldReceive('exec')->with('check ' . self::FILE_TO_CHECK)->andReturn(array());
        $executor->shouldReceive('exec')->with('check2 ' . self::FILE_TO_CHECK)->andReturn(array());

        $this->validator = new Validator($executor, array('validatorFoo' => 'check ####', 'validatorBar' => 'check2 ####'));
    }

    public function tearDown()
    {
        m::close();
    }


}