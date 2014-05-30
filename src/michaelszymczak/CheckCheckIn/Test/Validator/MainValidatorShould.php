<?php
namespace michaelszymczak\CheckCheckIn\Test\Validator;

use \michaelszymczak\CheckCheckIn\Validator\MainValidator;
use \Mockery as m;

/**
 * Class MainValidatorShould
 *
 * @covers michaelszymczak\CheckCheckIn\Validator\MainValidator
 */
class MainValidatorShould extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function validateAllGroups()
    {
        $mainValidator = $this->createMainValidatorAndExpectThatEachGroupValidatedOnce();

        $mainValidator->validate();
    }
    /**
     * @test
     */
    public function return0IfAllGroupsValid()
    {
        $mainValidator = $this->createMainValidatorWithTwoPasingGroup();

        $this->assertSame(0, $mainValidator->validate());
    }

    /**
     * @test
     */
    public function return1IfAllAtLeasOnGroupIsInvalid()
    {
        $mainValidator = $this->createMainValidatorWithOneFailingAndTwoPasingGroup();

        $this->assertSame(1, $mainValidator->validate());
    }

    /**
     * @test
     */
    public function displayPositiveFinalVerdictIfAllGroupsPassed()
    {
        $mainValidator = $this->createMainValidatorWithTwoPasingGroup();
        $this->display->shouldReceive('displayFinalVerdict')->with(true)->once();

        $mainValidator->validate();
    }

    /**
     * @test
     */
    public function displayNegativeFinalVerdictIfSomeGroupFailed()
    {
        $mainValidator = $this->createMainValidatorWithOneFailingAndTwoPasingGroup();
        $this->display->shouldReceive('displayFinalVerdict')->with(false)->once();

        $mainValidator->validate();
    }


    private $display;
    private $groupValidator;
    public function setUp()
    {
        $this->groupValidator = m::mock('\michaelszymczak\CheckCheckIn\Validator\GroupValidator');
        $this->display = m::mock('\michaelszymczak\CheckCheckIn\View\Display');
        $this->display->shouldReceive('displayFinalVerdict')->byDefault();
    }


    private function createMainValidatorAndExpectThatEachGroupValidatedOnce()
    {
        $groups = $this->createSomeGroups();
        foreach($groups as $group) {
            $this->groupValidator->shouldReceive('validate')->with($group)->once();
        }

        return $this->createMainValidatorWithGroups($groups);
    }

    private function createMainValidatorWithGroupsThatPassOrFailValidation($groupsThatPassOrFail)
    {
        $groups = $this->createSomeGroupsAndConfigureGroupValidator($groupsThatPassOrFail);

        return $this->createMainValidatorWithGroups($groups);
    }

    private function createMainValidatorWithTwoPasingGroup()
    {
        $mainValidator = $this->createMainValidatorWithGroupsThatPassOrFailValidation(array(
            $this->createGroupEntry(true),
            $this->createGroupEntry(true)
        ));
        return $mainValidator;
    }

    private function createMainValidatorWithOneFailingAndTwoPasingGroup()
    {
        $mainValidator = $this->createMainValidatorWithGroupsThatPassOrFailValidation(array(
            $this->createGroupEntry(true),
            $this->createGroupEntry(false),
            $this->createGroupEntry(true)
        ));
        return $mainValidator;
    }

    private function createGroupEntry($valid)
    {
        return array('group' => m::mock('\michaelszymczak\CheckCheckIn\Configuration\Group'), 'pass' => $valid);
    }

    private function createMainValidatorWithGroups($groups)
    {
        $mainValidator = new MainValidator($this->groupValidator, $this->display, $groups);
        return $mainValidator;
    }

    private function createSomeGroups()
    {
        $groups = array(
            m::mock('\michaelszymczak\CheckCheckIn\Configuration\Group'),
            m::mock('\michaelszymczak\CheckCheckIn\Configuration\Group')
        );
        return $groups;
    }

    private function createSomeGroupsAndConfigureGroupValidator($groupsThatPassOrFail)
    {
        $groups = array();
        foreach ($groupsThatPassOrFail as $group) {
            $this->groupValidator->shouldReceive('validate')->with($group['group'])->andReturn($group['pass']);
            $groups[] = $group['group'];
        }
        return $groups;
    }
}