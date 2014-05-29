<?php
namespace michaelszymczak\CheckCheckIn\View;

use \michaelszymczak\CheckCheckIn\Configuration\Config;
use michaelszymczak\CheckCheckIn\Response\ErrorResponse;
use michaelszymczak\CheckCheckIn\Response\SuccessResponse;

class Display {

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }
    public function display($message)
    {
        $stdout = $this->config->getStdout();
        $stdout($message);
    }
    public function displayFinalVerdict($isSuccess)
    {
        if ($isSuccess) {
            $response = new SuccessResponse($this->config->getSuccessMessage());
        } else {
            $response = new ErrorResponse($this->config->getFailureMessage());
        }

        $this->display($response->render(ShellView::createNewline()));
    }
}