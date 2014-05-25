<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\Validator;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\Validator
 */
class ValidatorWhenValidationFailedShould extends \PHPUnit_Framework_TestCase
{
    const FILE_TO_CHECK = 'Bar.java';

    /**
     * @test
     */
    public function returnFalseAsValidationResult()
    {
        $this->assertFalse($this->validator->validate(self::FILE_TO_CHECK));
    }

    /**
     * @test
     */
    public function returnErrorResponseWithFileName()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseWithFilename = $statusResponses[0];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\ErrorResponse', $statusResponseWithFilename);
        $this->assertSame(array('=> '. self::FILE_TO_CHECK .': '), $statusResponseWithFilename->getMessage());
    }

    /**
     * @test
     */
    public function returnInformationAboutFailedValidationOnlyForTheToolsThatFoundViolation()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $statusResponses = $this->validator->getStatusResponses();
        $statusResponseOfFirstTool = $statusResponses[1];
        $statusResponseOfSecondTool = $statusResponses[2];
        $statusResponseOfThirdTool = $statusResponses[3];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseOfFirstTool);
        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseOfSecondTool);
        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $statusResponseOfThirdTool);
        $this->assertSame(array('forgivingCheckValidator [PASSED]'), $statusResponseOfFirstTool->getMessage());
        $this->assertSame(array('seriousCheckValidator [FAILED]'), $statusResponseOfSecondTool->getMessage());
        $this->assertSame(array('anotherSourousCheckValidator [FAILED]'), $statusResponseOfThirdTool->getMessage());
    }

    /**
     * @test
     */
    public function returnWholeInformationAboutViolation()
    {
        $this->validator->validate(self::FILE_TO_CHECK);

        $descriptionResponses = $this->validator->getViolationnResponses();
        $firstToolResponses = $descriptionResponses[0];
        $secondToolResponses = $descriptionResponses[1];

        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $firstToolResponses);
        $this->assertInstanceOf('michaelszymczak\CheckCheckIn\Response\InfoResponse', $secondToolResponses);
        $this->assertSame(array('some problem title', 'some problem detailed description'), $firstToolResponses->getMessage());
        $this->assertSame(array('if you check against some option', 'you will find some problems'), $secondToolResponses->getMessage());
    }


    private $validator;

    public function setUp()
    {
        $executor = m::mock('\michaelszymczak\CheckCheckIn\Command\Executor\BadNewsExecutor');
        $executor->shouldReceive('exec')->with('forgivingCheckTool ' . self::FILE_TO_CHECK)->andReturn(array());
        $executor->shouldReceive('exec')->with('seriousCheckTool.sh ' . self::FILE_TO_CHECK)->andReturn(array('some problem title', 'some problem detailed description'));
        $executor->shouldReceive('exec')->with('anotherSeriousCheckTool ' . self::FILE_TO_CHECK . ' --someoption')->andReturn(array('if you check against some option', 'you will find some problems'));

        $this->validator = new Validator($executor, array('forgivingCheckValidator' => 'forgivingCheckTool ####', 'seriousCheckValidator' => 'seriousCheckTool.sh ####', 'anotherSourousCheckValidator' => 'anotherSeriousCheckTool #### --someoption'));
    }

    public function tearDown()
    {
        m::close();
    }


}