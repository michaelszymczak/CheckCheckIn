<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever;
use michaelszymczak\CheckCheckIn\Command\Git\GitFilesHarvesterFactory;
use michaelszymczak\CheckCheckIn\Configuration\Group;
use michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;
use \michaelszymczak\CheckCheckIn\View\Display;
use \michaelszymczak\CheckCheckIn\Configuration\DependencyManager;

class ValidatorFactory {
    private $display;
    private $manager;
    public function __construct(DependencyManager $manager)
    {
        $this->display = $manager->getDisplay();
        $this->manager = $manager;
    }
    public function createFileValidator(Group $group)
    {
        return new FileValidator(new Validator(new BadNewsOnlyExecutor(), $group->getToolPatterns()));
    }

    public function createMultipleFilesValidator()
    {
        return new MultipleFilesValidator($this->display);
    }

    public function createGroupValidator()
    {
        return new GroupValidator(
            $this->createMultipleFilesValidator(),
            $this->manager->getFilteredGitFilesRetriever(),
            $this);
    }

    public function getManager()
    {
        return $this->manager;
    }
}