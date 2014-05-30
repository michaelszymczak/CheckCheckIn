<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use \michaelszymczak\CheckCheckIn\View\Display;

class MainValidator
{
    private $groupValidator;
    private $display;
    private $groups;

    public function __construct(GroupValidator $groupValidator, Display $display, $groups)
    {
        $this->groupValidator = $groupValidator;
        $this->display = $display;
        $this->groups = $groups;
    }

    public function validate()
    {
        $allPassed = true;
        foreach($this->groups as $group) {
            if (!$this->groupValidator->validate($group)) {
                $allPassed = false;
            }
        }

        $this->display->displayFinalVerdict($allPassed);

        return $allPassed ? 0 : 1;
    }
}