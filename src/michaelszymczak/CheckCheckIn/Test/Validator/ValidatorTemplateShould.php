<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use michaelszymczak\CheckCheckIn\Response\ErrorResponse;
use michaelszymczak\CheckCheckIn\Response\InfoResponse;
use michaelszymczak\CheckCheckIn\Validator\Validator;
use \michaelszymczak\CheckCheckIn\Validator\ValidatorTemplate;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\ValidatorTemplate
 */
class ValidatorTemplateShould extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function renderValidatorStatusResponses()
    {
        $output = $this->validatorTemplate->validate('Foo.java');

        $this->assertStringStartsWith("\n", $output);
        $this->assertContains("Foo.java", $output);
        $this->assertContains("sometool [PASSED]", $output);
        $this->assertContains("someothertool [FAILED]", $output);
    }
    /**
     * @test
     */
    public function renderValidatorViolationResponses()
    {
        $output = $this->validatorTemplate->validate('Foo.java');

        $this->assertContains("Some problem", $output);
        $this->assertContains("Some problem description", $output);
        $this->assertContains("lorem ipsum", $output);
    }

    private $validatorTemplate;
    public function setUp()
    {
        $this->validator = new DummyValidator();
        $this->validator->dummyStatusResponsesFor['Foo.java'] = array(
            new ErrorResponse("=> Foo.java: "),
            new InfoResponse("sometool [PASSED]"),
            new InfoResponse("someothertool [FAILED]")
        );
        $this->validator->dummyViolationResponsesFor['Foo.java'] = array(
            new InfoResponse("Some problem"),
            new InfoResponse("Some problem description"),
            new InfoResponse("lorem ipsum")
        );

        $this->validatorTemplate = new ValidatorTemplate($this->validator);
    }

    public function tearDown()
    {
        m::close();
    }


}


class DummyValidator extends Validator {
    public $dummyStatusResponsesFor;
    public $dummyViolationResponsesFor;
    private $validateFilenameArgument = null;

    public function __construct()
    {

    }
    public function validate($filename)
    {
        $this->validateFilenameArgument = $filename;
    }
    public function getStatusResponses()
    {
        if (!isset($this->dummyStatusResponsesFor[$this->validateFilenameArgument])) {
            throw new \RuntimeException("filename not validated yet");
        }
        return $this->dummyStatusResponsesFor[$this->validateFilenameArgument];
    }
    public function getViolationResponses()
    {
        if (!isset($this->dummyViolationResponsesFor[$this->validateFilenameArgument])) {
            throw new \RuntimeException("filename not validated yet");
        }
        return $this->dummyViolationResponsesFor[$this->validateFilenameArgument];
    }
}