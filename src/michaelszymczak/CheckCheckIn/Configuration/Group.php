<?php
namespace michaelszymczak\CheckCheckIn\Configuration;

class Group
{
    private $params;
    public function __construct($params)
    {
        $this->params = $params;
        $this->throwExpcetionIfNo('files');
        $this->throwExpcetionIfNo('tools');

    }
    public function getFilePatterns()
    {
        return $this->params['files'];
    }
    public function getToolPatterns()
    {
        return $this->params['tools'];
    }

    private function throwExpcetionIfNo($param)
    {
        if (!isset($this->params[$param])) {
            throw new \InvalidArgumentException("Missing required {$param} parameter");
        }
    }

}