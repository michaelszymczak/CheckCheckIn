<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use michaelszymczak\CheckCheckIn\Configuration\Group;
use michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;
use \michaelszymczak\CheckCheckIn\View\Display;
use \michaelszymczak\CheckCheckIn\Configuration\DependencyManager;

class ValidatorFactory {
    private $manager;
    public function __construct(DependencyManager $manager)
    {
        $this->manager = $manager;
    }
    public function createFileValidator(Group $group)
    {
        return new FileValidator(new Validator(new BadNewsOnlyExecutor(), $group->getToolPatterns()));
    }

    public function createMultipleFilesValidator()
    {
        return new MultipleFilesValidator($this->manager->getDisplay());
    }
}