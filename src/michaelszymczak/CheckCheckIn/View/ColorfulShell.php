<?php
namespace michaelszymczak\CheckCheckIn\View;

class ColorfulShell {
    const WHITE_FG = '1;37';
    const BLUE_FG = '0;34';
    const BLUE_BG = '44';
    const GREEN_FG = '0;32';
    const GREEN_BG = '42';
    const GRAY_FG = '0;37';
    const BLACK_FG = '0;30';
    const BLACK_BG = '40';
    const RED_BG = '41';

    public function colorize($string, $color = null, $bgColor = null) {
        $output = "";
        $colorTagOpened = false;
        if (null !== $color) {
            $output .= "\033[" . $color . "m";
            $colorTagOpened = true;
        }
        if (null !== $bgColor) {
            $colorTagOpened = true;
            $output .= "\033[" . $bgColor . "m";
        }

        $output .= $string;

        if ($colorTagOpened) {
            $output .= "\033[0m";
        }

        return $output;
    }
}