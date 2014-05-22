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

    public function error($messages)
    {
        return $this->linePolicy . $this->renderFragment($messages, ColorfulShell::WHITE_FG, ColorfulShell::RED_BG);
    }

    public function info($messages)
    {
        return $this->linePolicy . $this->renderFragment($messages, ColorfulShell::GRAY_FG);
    }

    public function success($messages)
    {
        return $this->linePolicy . $this->renderFragment($messages, ColorfulShell::WHITE_FG, ColorfulShell::GREEN_BG);
    }

    public function raw($messages)
    {
        return $this->linePolicy . $this->renderFragment($messages);
    }

    /**
     * @param array       $fragments Fragment of the message
     * @param null|string $fgColor   Foreground color
     * @param null|string $bgColor   Background color
     *
     * @return string Wrapped fragment
     */
    private function renderFragment($fragments, $fgColor = null, $bgColor = null)
    {
        $fragment = $fragments[0];
        return $this->cs->colorize($fragment, $fgColor, $bgColor);
    }

}