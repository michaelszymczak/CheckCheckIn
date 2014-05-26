<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\ValidatorTemplateFactory;

/**
 * Class ValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\ValidatorTemplateFactory
 */
class ValidatorTemplateFactoryShould extends \PHPUnit_Framework_TestCase
{
    private $factory;
    /**
     * @test
     */
    public function createValidatorTemplateContainingValidatorWithPassedPatterns()
    {
        $validatorTemplate = $this->factory->create(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'));
        $validatorTemplate2 = $this->factory->create(array());

        $this->assertSame(array('toolA' => 'tool.sh ####', 'toolB' => 'otherTool #### -Doption'), $validatorTemplate->getValidator()->getPatterns());
        $this->assertSame(array(), $validatorTemplate2->getValidator()->getPatterns());
    }
    public function setUp()
    {
        $this->factory = new ValidatorTemplateFactory();
    }

}