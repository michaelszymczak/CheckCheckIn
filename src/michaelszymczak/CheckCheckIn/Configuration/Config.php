<?php
namespace michaelszymczak\CheckCheckIn\Configuration;

class Config {
    private $params;

    public function __construct($params)
    {
        $this->params = array(
            'success' => array('-----------------', 'Validation passed', '-----------------'),
            'failure' => array('-----------------', 'Validation failed', '-----------------'),
            'blacklist' => array(),
            'stdout' => function($msg) { echo $msg; }
        );

        foreach($params as $key => $param) {
            $this->params[$key] = $param;
        }
    }

    public function stdout($message)
    {
        $stdout = $this->params['stdout'];
        $stdout($message);
    }

    public function getSuccessMessage()
    {
        return $this->params['success'];
    }

    public function getFailureMessage()
    {
        return $this->params['failure'];

    }
    public function getBlacklist()
    {
        return $this->params['blacklist'];
    }

}