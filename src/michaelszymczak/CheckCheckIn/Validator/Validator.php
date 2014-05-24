<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use \michaelszymczak\CheckCheckIn\Command\Executor\BadNewsExecutor;
use michaelszymczak\CheckCheckIn\Response\ErrorResponse;
use michaelszymczak\CheckCheckIn\Response\InfoResponse;
use michaelszymczak\CheckCheckIn\Response\SuccessResponse;

class Validator {
    private $executor;
    private $patterns;
    private $statusResponses = array();
    public function __construct(BadNewsExecutor $executor, $patterns)
    {
        $this->executor = $executor;
        $this->patterns = $patterns;
    }

    public function validate($filename)
    {
        $this->statusResponses[] = new SuccessResponse("=> {$filename}: ");
        foreach ($this->patterns as $tool => $pattern) {
            $fullCmd = str_replace('####', $filename, $pattern);
            $this->executor->exec($fullCmd);
            $this->statusResponses[] = new InfoResponse("{$tool} [PASSED]");
        }

        return true;
    }

    public function getStatusResponses()
    {
        return $this->statusResponses;
    }
    public function getViolationDescritpion()
    {
        return new InfoResponse(array());
    }
}