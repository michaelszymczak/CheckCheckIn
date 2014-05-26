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
    public function __construct(BadNewsOnlyExecutor $executor, $patterns)
    {
        $this->executor = $executor;
        $this->patterns = $patterns;
    }

    public function validate($filename)
    {
        $allOK = true;
        $this->statusResponses = array(0 => null); // placeholder for the first entry - filename
        $this->violationResponses = array();
        foreach ($this->patterns as $tool => $pattern) {
            $fullCmd = str_replace('####', $filename, $pattern);
            $result = $this->executor->exec($fullCmd);
            if (empty($result)) {
                $this->statusResponses[] = new InfoResponse("{$tool} [PASSED]");
            } else {
                $allOK = false;
                $this->statusResponses[] = new InfoResponse("{$tool} [FAILED]");
                $this->violationResponses[] = new InfoResponse($result);
            }
        }
        $this->statusResponses[0] = $allOK ? new SuccessResponse("=> {$filename}: ") : new ErrorResponse("=> {$filename}: ");

        return $allOK;
    }

    public function getStatusResponses()
    {
        return $this->statusResponses;
    }

    public function getViolationResponses()
    {
        return $this->violationResponses;
    }
}