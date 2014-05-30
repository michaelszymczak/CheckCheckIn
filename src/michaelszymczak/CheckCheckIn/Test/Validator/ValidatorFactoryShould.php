<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use michaelszymczak\CheckCheckIn\Configuration\DependencyManager;
use michaelszymczak\CheckCheckIn\Configuration\Group;
use \michaelszymczak\CheckCheckIn\Validator\ValidatorFactory;
use michaelszymczak\CheckCheckIn\Configuration\Config;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\ValidatorFactory
 */
class ValidatorFactoryShould extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createFileValidatorContainingValidatorWithPassedPatterns()
    {
        $group = $this->createGroupWithTools(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'));

        $fileValidator = $this->factory->createFileValidator($group);

        $this->assertSame(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'), $fileValidator->getValidator()->getPatterns());
    }
    /**
     * @test
     */
    public function createFileValidatorContainingValidatorWithEmptyPatternsWhenEmptyPatternsPassed()
    {
        $group = $this->createGroupWithTools(array());

        $fileValidator = $this->factory->createFileValidator($group);

        $this->assertSame(array(), $fileValidator->getValidator()->getPatterns());
    }
    /**
     * @test
     * @covers michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator::getDisplay
     */
    public function createMultipleFilesValidatorUsingDisplayCreatedBasedOnConfig()
    {
        $multipleFilesValidator = $this->factory->createMultipleFilesValidator();

        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Validator\MultipleFilesValidator', $multipleFilesValidator);
        $this->assertSame($this->display, $multipleFilesValidator->getDisplay());

    }
    /**
     * @test
     * @covers \michaelszymczak\CheckCheckIn\Validator\GroupValidator::getMultipleFilesValidator
     * @covers \michaelszymczak\CheckCheckIn\Validator\GroupValidator::getFilesRetriever
     */
    public function createGroupValidator()
    {
        $groupValidator = $this->factory->createGroupValidator();

        $this->groupValidatorCreatedWithCorrectManagerAndFactoryDependencies($groupValidator);
    }


    private $factory;
    private $display;
    private $manager;
    public function setUp()
    {
        $this->manager = new DependencyManager(new Config(array('config' => array(), 'groups' => array())));
        $this->display = $this->manager->getDisplay();
        $this->factory = new ValidatorFactory($this->manager);
    }

    private function createGroupWithTools($tools)
    {
        return new Group(array('files' => array(), 'tools' => $tools));
    }


    private function groupValidatorCreatedWithCorrectManagerAndFactoryDependencies($groupValidator)
    {
        $this->assertInstanceOf('\michaelszymczak\CheckCheckIn\Validator\GroupValidator', $groupValidator);
        $this->assertSame($this->manager->getDisplay(), $groupValidator->getMultipleFilesValidator()->getDisplay());
        $this->assertSame($this->manager->getFilteredGitFilesRetriever()->getHarvester(), $groupValidator->getFilesRetriever()->getHarvester());
        $this->assertSame($this->manager->getFilteredGitFilesRetriever()->getBlacklist(), $groupValidator->getFilesRetriever()->getBlacklist());
        $this->assertSame($this->factory, $groupValidator->getValidatorFactory());
    }
}