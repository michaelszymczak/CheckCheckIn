<?php
namespace michaelszymczak\CheckCheckIn;

use michaelszymczak\CheckCheckIn\Configuration\DependencyManager;

class CCI {
    public static function check($params, $argv = null)
    {
        return DependencyManager::create($params, $argv)->getValidator()->validate();
    }
}