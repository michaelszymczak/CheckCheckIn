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
    public function createValidatorTemplateContainingValidatorWithPassedPatterns()
    {
        $group = $this->createGroupWithTools(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'));

        $validatorTemplate = $this->factory->createFileValidator($group);

        $this->assertSame(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'), $validatorTemplate->getValidator()->getPatterns());
    }
    /**
     * @test
     */
    public function createValidatorTemplateContainingValidatorWithEmptyPatternsWhenEmptyPatternsPassed()
    {
        $group = $this->createGroupWithTools(array());

        $validatorTemplate = $this->factory->createFileValidator($group);

        $this->assertSame(array(), $validatorTemplate->getValidator()->getPatterns());
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