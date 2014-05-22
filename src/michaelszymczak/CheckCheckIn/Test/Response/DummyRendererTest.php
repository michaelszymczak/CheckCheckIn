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

    public function error($messages)
    {
        return $this->methods['error']($messages);
    }

    public function info($messages)
    {
        return $this->methods['info']($messages);
    }

    public function success($messages)
    {
        return $this->methods['success']($messages);
    }
}
