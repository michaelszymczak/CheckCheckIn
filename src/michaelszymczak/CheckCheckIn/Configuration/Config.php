<?php
namespace michaelszymczak\CheckCheckIn\Configuration;

use michaelszymczak\CheckCheckIn\View\Display;

class Config {

    private $config = array();
    private $groups = array();
    private $display;

    public function __construct($params)
    {
        $this->createConfigBasedOnConfigParams($params);
        $this->createGroupsBasedOnGroupParams($params);
        $this->display = new Display($this);
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
    public function getDisplay()
    {
        return $this->display;
    }

    private function createGroupsBasedOnGroupParams($params)
    {
        foreach ($params['groups'] as $groupConfig) {
            $this->groups[] = new Group($groupConfig);
        }
    }

    private function createConfigBasedOnConfigParams($params)
    {
        $this->prepareDefaultConfigParams();
        foreach ($params['config'] as $key => $param) {
            $this->config[$key] = $param;
        }
    }

    private function prepareDefaultConfigParams()
    {
        $this->config = array(
            'success' => array('-----------------', 'Validation passed', '-----------------'),
            'failure' => array('-----------------', 'Validation failed', '-----------------'),
            'blacklist' => array(),
            'stdout' => function ($msg) {
                    echo $msg;
                }
        );
    }
}