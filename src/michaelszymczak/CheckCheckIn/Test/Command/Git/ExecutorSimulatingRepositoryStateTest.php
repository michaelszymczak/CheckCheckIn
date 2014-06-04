<?php
namespace michaelszymczak\CheckCheckIn\Test\Command\Git;

use michaelszymczak\CheckCheckIn\Command\Executor\Executor;
use \Mockery as m;

class ExecutorSimulatingRepositoryStateTest extends Executor {

    private $output;

    public function configure($files)
    {
        $this->output = array(
            'git diff-files --name-only --diff-filter=ACMU 2>&1' => $files['modified'],
            'git diff-index --cached --name-only --diff-filter=ACMU HEAD 2>&1' => $files['staged'],
            'git diff-index --cached --name-only --diff-filter=ACMU 4b825dc642cb6eb9a060e54bf8d69288fbee4904 2>&1' => $files['staged'],
            'git ls-files --other --exclude-standard 2>&1' => $files['untracked'],
        );
    }

    protected function executeAndReturnOutput($command)
    {
        if (!isset($this->output[$command])) {
            throw new \RuntimeException("Command {$command} not configured in " . __CLASS__);
        }
        return $this->output[$command];
    }
}