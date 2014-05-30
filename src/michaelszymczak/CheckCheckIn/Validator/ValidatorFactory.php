<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use michaelszymczak\CheckCheckIn\Configuration\Group;
use michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;

class ValidatorFactory {
    public function createFileValidator(Group $group)
    {
        return new FileValidator(new Validator(new BadNewsOnlyExecutor(), $group->getToolPatterns()));
    }
}