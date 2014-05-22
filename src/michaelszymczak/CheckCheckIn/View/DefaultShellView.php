<?php
namespace michaelszymczak\CheckCheckIn\View;

class DefaultShellView extends ShellView
{
    protected function mergeWrapped($wrappedFragments)
    {
        return "\n" . implode(" ", $wrappedFragments);
    }
}