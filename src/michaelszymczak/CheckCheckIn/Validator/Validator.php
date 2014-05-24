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
    private $detailedResponses = array();
    public function __construct(BadNewsExecutor $executor, $patterns)
    {
        $this->executor = $executor;
        $this->patterns = $patterns;
    }

    public function validate($filename)
    {
        $allOK = true;
        $this->statusResponses[0] = null; // filename placeholder
        $this->detailedResponses = array();
        foreach ($this->patterns as $tool => $pattern) {
            $fullCmd = str_replace('####', $filename, $pattern);
            $result = $this->executor->exec($fullCmd);
            if (empty($result)) {
                $this->statusResponses[] = new InfoResponse("{$tool} [PASSED]");
            } else {
                $allOK = false;
                $this->statusResponses[] = new InfoResponse("{$tool} [FAILED]");
                $this->detailedResponses[] = new InfoResponse($result);
            }
        }
        $this->statusResponses[0] = $allOK ? new SuccessResponse("=> {$filename}: ") : new ErrorResponse("=> {$filename}: ");

        return $allOK;
    }

    public function getStatusResponses()
    {
        return $this->statusResponses;
    }
    public function getViolationnResponses()
    {
        return $this->detailedResponses;
    }
}