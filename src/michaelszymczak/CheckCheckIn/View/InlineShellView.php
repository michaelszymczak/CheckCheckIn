<?php
namespace michaelszymczak\CheckCheckIn\View;

class InlineShellView extends ShellView
{
    protected function mergeWrapped($wrappedFragments)
    {
        return implode(" ", $wrappedFragments);
    }
}