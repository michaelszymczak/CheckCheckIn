<?php
namespace michaelszymczak\CheckCheckIn\View;

use \michaelszymczak\CheckCheckIn\Response\ResponseRenderer;

abstract class ShellView implements ResponseRenderer {

    protected $cs;


    public function __construct(ColorfulShell $cs)
    {
        $this->cs = $cs;
    }

    public static function createInline()
    {
        return new InlineShellView(new ColorfulShell);
    }

    public static function createNewline()
    {
        return new NewlineShellView(new ColorfulShell);
    }

    public static function createDefault()
    {
        return new DefaultShellView(new ColorfulShell);
    }

    public function error($messages)
    {
        return $this->renderFragment($messages, ColorfulShell::WHITE_FG, ColorfulShell::RED_BG);
    }

    public function info($messages)
    {
        return $this->renderFragment($messages, ColorfulShell::GRAY_FG);
    }

    public function success($messages)
    {
        return $this->renderFragment($messages, ColorfulShell::WHITE_FG, ColorfulShell::GREEN_BG);
    }

    public function raw($messages)
    {
        return $this->renderFragment($messages);
    }

    /**
     * @param array       $fragments Fragment of the message
     * @param null|string $fgColor   Foreground color
     * @param null|string $bgColor   Background color
     *
     * @return string Wrapped fragment
     */
    protected function renderFragment($fragments, $fgColor = null, $bgColor = null)
    {
        $wrapped = array();
        foreach($fragments as $fragment) {
            $wrapped[] = $this->cs->colorize($fragment, $fgColor, $bgColor);
        }

        return $this->mergeWrapped($wrapped);
    }

    abstract protected function mergeWrapped($wrappedFragments);

}