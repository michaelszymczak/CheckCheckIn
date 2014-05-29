<?php
namespace michaelszymczak\CheckCheckIn\Configuration;

use michaelszymczak\CheckCheckIn\View\Display;

class DependencyManager {

    private $display;
    private $groups;

    public function __construct(Config $config)
    {
        $this->display = new Display($config);
        $this->createGroupObjectssBasedOnConfig($config);
    }

    public function getDisplay()
    {
        return $this->display;
    }
    public function getGroups()
    {
        return $this->groups;
    }

    private function createGroupObjectssBasedOnConfig($config)
    {
        foreach ($config->getGroups() as $groupConfig) {
            $this->groups[] = new Group($groupConfig);
        }
    }

}