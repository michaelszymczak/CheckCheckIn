<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use \michaelszymczak\CheckCheckIn\Command\Git\FilteredGitFilesRetriever;
use michaelszymczak\CheckCheckIn\Configuration\Group;

class GroupValidator
{
    private $validatorFactory;
    private $filesRetriever;
    private $multipleFilesValidator;

    public function __construct(MultipleFilesValidator $multipleFilesValidator, FilteredGitFilesRetriever $filesRetriever, ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
        $this->filesRetriever = $filesRetriever;
        $this->multipleFilesValidator = $multipleFilesValidator;
    }

    public function validate(Group $group)
    {
        return $this->multipleFilesValidator->validate(
            $this->validatorFactory->createFileValidator($group),
            $this->filesRetriever->getFiles($group)
        );
    }

    public function getMultipleFilesValidator()
    {
        return $this->multipleFilesValidator;
    }

    public function getFilesRetriever()
    {
        return $this->filesRetriever;
    }

    public function getValidatorFactory()
    {
        return $this->validatorFactory;
    }

}