<?php
namespace michaelszymczak\CheckCheckIn\Test\Response;

use \michaelszymczak\CheckCheckIn\Response\ResponseRenderer;

class DummyRendererTest implements ResponseRenderer
{
    private $methods;

    public function expect($methods)
    {
        $this->methods = $methods;
    }

    public function error($message)
    {
        return $this->methods['error']($message);
    }

    public function info($message)
    {
        return $this->methods['info']($message);
    }

    public function success($message)
    {
        return $this->methods['success']($message);
    }
}
