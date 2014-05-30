<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator;
use \michaelszymczak\CheckCheckIn\Validator\FileValidator;
use \michaelszymczak\CheckCheckIn\View\Display;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator
 */
class MultipleFilesValidatorShould extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function validateEachFile()
    {
        $fileValidator = $this->configureFileValidation(array('valid.js' => true, 'invalid.js' => false, 'anotherValid.js' => true));
        $overallResult = $this->validator->validate($fileValidator, array('valid.js', 'invalid.js', 'anotherValid.js'));
        $this->assertFalse($overallResult);
    }
    /**
     * @test
     */
    public function returnResultBasedOnFileValidatorOverallResult()
    {
        $fileValidator = $this->configureFileValidation(array('valid.js' => true, 'anotherValid.js' => true));
        $overallResult = $this->validator->validate($fileValidator, array('anotherValid.js', 'valid.js'));
        $this->assertTrue($overallResult);
    }
    /**
     * @test
     */
    public function displayResultForEachFileValidation()
    {
        $this->display->shouldReceive('display')->with('FAILURE: Invalid.java')->once();
        $this->display->shouldReceive('display')->with('OK: Valid.java')->once();

        $fileValidator = $this->configureFileValidation(array('Valid.java' => true, 'Invalid.java' => false));
        $this->validator->validate($fileValidator, array('Invalid.java', 'Valid.java'));

    }


    private $display;
    private $validator;
    public function setUp()
    {
        $this->display = m::mock('\michaelszymczak\CheckCheckIn\View\Display');
        $this->display->shouldReceive('display')->byDefault();
        $this->validator = new MultipleFilesValidator($this->display);
    }

    private function configureFileValidation($configuration)
    {
        $fileValidator = new DummyFileValidator(m::mock('\michaelszymczak\CheckCheckIn\Validator\Validator'));
        $fileValidator->configuration = $configuration;
        return $fileValidator;
    }
}

class DummyFileValidator extends FileValidator
{
    public $configuration = array();
    private $areValid = true;

    public function validate($filename)
    {
        $response = "";
        if (!isset($this->configuration[$filename])) {
            throw new \RuntimeException;
        }
        if (true === $this->configuration[$filename]) {
            $response = "OK: {$filename}";
        }
        if (false === $this->configuration[$filename]) {
            $this->areValid = false;
            $response = "FAILURE: {$filename}";
        }
        unset($this->configuration[$filename]);
        return $response;
    }
    public function areValid()
    {
        if (count($this->configuration) > 0) {
            throw new \RuntimeException('validate method not run for each file');
        }
        return $this->areValid;
    }
}