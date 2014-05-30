<?php
namespace michaelszymczak\CheckCheckIn\Test\Configuration;

use \michaelszymczak\CheckCheckIn\Configuration\Config;

class ConfigInputHelperTest
{
    public function prepare($config = array(), $groups = array())
    {
        $defaultConfig = array(
            'success' => array('foo'),
            'failure' => array('bar'),
            'blacklist' => array('baz'),
            'candidates' => 'staged'
        );

        foreach($config as $key => $value) {
            $defaultConfig[$key] = $value;
        }

        return array(
            'config' => $defaultConfig,
            'groups' => $groups
        );
    }
    public function prepareWithGroupsConfiguration($groupConfiguration)
    {
        $input = $this->prepare(array(), $groupConfiguration);
        $config = new Config($input);

        return $config;
    }
    public function createConfig($config = array(), $groups = array())
    {
        return new Config($this->prepare($config, $groups));
    }
}