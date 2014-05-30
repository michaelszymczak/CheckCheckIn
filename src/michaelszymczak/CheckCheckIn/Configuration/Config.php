<?php
namespace michaelszymczak\CheckCheckIn\Configuration;

class Config {

    private $config = array();
    private $groups = array();

    const CANDIDATES_MODIFIED = 'modified';
    const CANDIDATES_STAGED = 'staged';

    public function __construct($params)
    {
        $this->createConfigBasedOnConfigParams($params);
        $this->groups = $params['groups'];
    }

    public function getSuccessMessage()
    {
        return $this->config['success'];
    }

    public function getStdout()
    {
        return $this->config['stdout'];
    }

    public function getFailureMessage()
    {
        return $this->config['failure'];

    }
    public function getBlacklist()
    {
        return $this->config['blacklist'];
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function getCandidates()
    {
        return $this->config['candidates'];
    }
    private function createConfigBasedOnConfigParams($params)
    {
        $this->prepareDefaultConfigParams();
        foreach ($params['config'] as $key => $param) {
            $this->config[$key] = $param;
        }
        if (!in_array($this->config['candidates'], array('staged', 'modified'))) {
            throw new \InvalidArgumentException('Unallowed candidates parameter: ' . $this->config['candidates']);
        }
    }

    private function prepareDefaultConfigParams()
    {
        $this->config = array(
            'success' => array('-----------------', 'Validation passed', '-----------------'),
            'failure' => array('-----------------', 'Validation failed', '-----------------'),
            'blacklist' => array(),
            'candidates' => 'staged',
            'stdout' => function ($msg) {
                    echo $msg;
                }
        );
    }
}