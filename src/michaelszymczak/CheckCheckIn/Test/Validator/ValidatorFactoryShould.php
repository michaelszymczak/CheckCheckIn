<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use michaelszymczak\CheckCheckIn\Configuration\Group;
use \michaelszymczak\CheckCheckIn\Validator\ValidatorFactory;

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


    private $factory;
    public function setUp()
    {;
        $this->factory = new ValidatorFactory();
    }

    private function createGroupWithTools($tools)
    {
        return new Group(array('files' => array(), 'tools' => $tools));
    }
}