<?php
namespace michaelszymczak\CheckCheckIn\Test;

use michaelszymczak\CheckCheckIn\CCI;
/**
 * Class CCIShould
 *
 * @covers michaelszymczak\CheckCheckIn\CCI
 */
class CCIShould extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function berunInGitRepository()
    {
        $params = $this->prepareParamsThatDisplayGivenStringIfValidationSucceeds(' works! ');

        $this->expectOutputWithSuccessMessageContaining(' works! ');

        CCI::check($params);
    }

    /**
     * @test
     */
    public function beRunWithModeSelection()
    {
        $params = $this->prepareParamsThatDisplayGivenStringIfValidationSucceeds(' still works! ');
        $argv = array(0 => 'not/important/path/to/script', 1 => '--staged'); // possible: --staged and --modified

        $this->expectOutputWithSuccessMessageContaining(' still works! ');

        CCI::check($params, $argv);
    }
    /**
     * @test
     */
    public function returnExitCode()
    {
        $params = $this->prepareParamsThatDisplayGivenStringIfValidationSucceeds('success');

        $this->expectOutputWithSuccessMessageContaining('success');

        $this->assertSame(0, CCI::check($params)); // 1 if failure
    }

    private function prepareParamsThatDisplayGivenStringIfValidationSucceeds($message)
    {
        $params = array(
            'config' => array(
                'success' => array($message)
            ),
            'groups' => array()
        );

        return $params;
    }

    private function expectOutputWithSuccessMessageContaining($message)
    {
        $this->expectOutputString("\n\033[1;37m\033[42m{$message}\033[0m");
    }
}