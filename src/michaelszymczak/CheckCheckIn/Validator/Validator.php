<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use \michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;
use michaelszymczak\CheckCheckIn\Response\ErrorResponse;
use michaelszymczak\CheckCheckIn\Response\InfoResponse;
use michaelszymczak\CheckCheckIn\Response\SuccessResponse;

class Validator {
    private $executor;
    private $patterns;
    private $statusResponses = array();
    private $violationResponses = array();
    private $areValid = true;
    const PATTERN_FILE_PLACEHOLDER = '####';

    public function __construct(BadNewsOnlyExecutor $executor, $patterns)
    {
        $this->executor = $executor;
        $this->patterns = $patterns;
    }

    public function validate($filename)
    {
        $this->clearResponses();
        $isFileValid = $this->runAllValidationsForGivenFile($filename);
        $this->addFilenameToStatusResponse($filename, $isFileValid);

    }

    public function getStatusResponses()
    {
        return $this->statusResponses;
    }

    public function getViolationResponses()
    {
        return $this->violationResponses;
    }

    public function areValid()
    {
        return $this->areValid;
    }

    public function getPatterns()
    {
        return $this->patterns;
    }



    private function clearResponses()
    {
        $this->statusResponses = array(0 => null); // placeholder for the first entry - filename
        $this->violationResponses = array();
    }

    private function runAllValidationsForGivenFile($filename)
    {
        $isFileValid = true;
        foreach ($this->patterns as $tool => $pattern) {
            if (!$this->validateFileUsingToolWithGivenPattern($filename, $pattern, $tool)) {
                $isFileValid = false;
            }

        }
        return $isFileValid;
    }

    private function validateFileUsingToolWithGivenPattern($filename, $pattern, $tool)
    {
        $isFileValidAccordingToGivenTool = true;
        $result = $this->executor->exec($this->prepareCommand($filename, $pattern));
        $this->populateResponses($result, $tool);
        if (!$this->noViolations($result)) {
            $isFileValidAccordingToGivenTool = false;
            $this->flagViolation();
        }

        return $isFileValidAccordingToGivenTool;
    }

    private function prepareCommand($filename, $pattern)
    {
        $fullCmd = str_replace(self::PATTERN_FILE_PLACEHOLDER, $filename, $pattern);
        return $fullCmd;
    }

    private function populateResponses($result, $tool)
    {
        $allOK = true;
        if ($this->noViolations($result)) {
            $this->addInformationAboutPassedValidationToStatusResponses($tool);
        } else {
            $allOK = false;
            $this->addInformationAboutFailedValidationToStatusResponses($tool);
            $this->addDetailsToViolationResponse($result);
        }
        return $allOK;
    }

    private function noViolations($result)
    {
        return empty($result);
    }

    private function flagViolation()
    {
        $this->areValid = false;
    }

    private function addFilenameToStatusResponse($filename, $allOK)
    {
        $this->statusResponses[0] = $allOK ? new SuccessResponse("=> {$filename}: ") : new ErrorResponse("=> {$filename}: ");
    }

    private function addInformationAboutPassedValidationToStatusResponses($tool)
    {
        $this->statusResponses[] = new InfoResponse("{$tool} [PASSED]");
    }

    private function addInformationAboutFailedValidationToStatusResponses($tool)
    {
        $this->statusResponses[] = new InfoResponse("{$tool} [FAILED]");
    }

    private function addDetailsToViolationResponse($result)
    {
        $this->violationResponses[] = new InfoResponse($result);
    }

}