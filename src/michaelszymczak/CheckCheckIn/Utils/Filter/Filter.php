<?php
namespace michaelszymczak\CheckCheckIn\Utils\Filter;

class Filter
{
    const PHP = '/\.php$/';
    const JS = '/\.js$/';
    const JAVA = '/\.java$/';
    const LESS = '/\.less$/';

    private $whitelist = array();
    private $blacklist = array();

    public function __construct($allowedPatterns, $disallowedPatterns = array())
    {
        $this->whitelist = $allowedPatterns;
        $this->blacklist = $disallowedPatterns;
    }

    public function filter($inputPaths)
    {
        return $this->removeBlacklisted(
            $this->addWhitelisted($inputPaths)
        );
    }

    private function addWhitelisted($inputPaths)
    {
        $outputPaths = array();
        foreach ($inputPaths as $path) {
            foreach ($this->whitelist as $pattern) {
                if (preg_match($pattern, $path) && !in_array($path, $outputPaths)) {
                    $outputPaths[] = $path;
                }
            }
        }

        return $outputPaths;
    }

    private function removeBlacklisted($paths)
    {
        foreach ($paths as $index => $path) {
            foreach ($this->blacklist as $pattern) {
                if (preg_match($pattern, $path)) {
                    unset($paths[$index]);
                }
            }
        }

        return array_values($paths);
    }
}
