<?php
namespace michaelszymczak\CheckCheckIn\View;

use \michaelszymczak\CheckCheckIn\Response\ResponseRenderer;

class ShellView implements ResponseRenderer {

    private $cs;
    private $linePolicy;

    const INLINE = "";
    const NEWLINE = "\n";

    public function __construct(ColorfulShell $cs, $linePolicy = self::NEWLINE)
    {
        $this->cs = $cs;
        $this->linePolicy = $linePolicy;
    }

    public function error($message)
    {
        return $this->linePolicy . $this->cs->colorize($message, ColorfulShell::WHITE_FG, ColorfulShell::RED_BG);
    }

    public function info($message)
    {
        return $this->linePolicy . $this->cs->colorize($message, ColorfulShell::GRAY_FG);
    }

    public function success($message)
    {
        return $this->linePolicy . $this->cs->colorize($message, ColorfulShell::WHITE_FG, ColorfulShell::GREEN_BG);
    }

    public function raw($message)
    {
        return $this->linePolicy . $this->cs->colorize($message);
    }

}