<?php
namespace michaelszymczak\CheckCheckIn\View;

class NewlineShellView extends ShellView {

    protected function mergeWrapped($wrappedFragments)
    {
        return "\n" . implode("\n", $wrappedFragments);
    }
}