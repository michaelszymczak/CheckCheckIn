<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\GroupValidator;
use \michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator;
use \Mockery as m;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\GroupValidator
 */
class GroupValidatorShould extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function informIfValidationPassed()
    {
        $this->multipleFilesValidator->shouldReceive('validate')->with($this->fileValidator, $this->foundFiles)->andReturn(true);

        $groupValidationResuls = $this->groupValidator->validate($this->group);

        $this->assertTrue($groupValidationResuls);
    }
    /**
     * @test
     */
    public function informIfValidationFailed()
    {
        $this->multipleFilesValidator->shouldReceive('validate')->with($this->fileValidator, $this->foundFiles)->andReturn(false);

        $groupValidationResuls = $this->groupValidator->validate($this->group);

        $this->assertFalse($groupValidationResuls);
    }
    /**
     * @test
     */
    public function runValidationOnlyOnceForGroup()
    {
        $this->multipleFilesValidator->shouldReceive('validate')->with($this->fileValidator, $this->foundFiles)->once();

        $this->groupValidator->validate($this->group);

    }


    private $multipleFilesValidator;
    private $fileValidator;
    private $group;
    private $groupValidator;

    private $foundFiles;

    public function setUp()
    {
        $this->foundFiles = array('foo.js', 'bar.js');
        $this->group = m::mock('\michaelszymczak\CheckCheckIn\Configuration\Group');
        $this->fileValidator = m::mock('\michaelszymczak\CheckCheckIn\Validator\FileValidator');
        $this->multipleFilesValidator = m::mock('\michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator');

        $this->groupValidator = new GroupValidator($this->multipleFilesValidator, $this->getFilesRetriever(), $this->getValidatorFactory());
    }

    public function tearDown()
    {
        m::close();
    }


    private function getValidatorFactory()
    {
        $validatorFactory = m::mock('\michaelszymczak\CheckCheckIn\Validator\ValidatorFactory');
        $validatorFactory->shouldReceive('createFileValidator')->with($this->group)->andReturn($this->fileValidator);

        return $validatorFactory;
    }

    private function getFilesRetriever()
    {
        $filesRetriever = m::mock('\michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever');
        $filesRetriever->shouldReceive('getFiles')->with($this->group)->andReturn($this->foundFiles);
        return $filesRetriever;
    }
}