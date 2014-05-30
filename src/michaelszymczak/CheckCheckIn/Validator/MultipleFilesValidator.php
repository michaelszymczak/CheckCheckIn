<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use \michaelszymczak\CheckCheckIn\View\Display;

class MultipleFilesValidator {

    private $display;

    public function __construct(Display $display)
    {
        $this->display = $display;
    }

    public function validate(FileValidator $fileValidator, $files)
    {
        foreach ($files as $file) {
            $this->display->display($fileValidator->validate($file));
        }

        return $fileValidator->areValid();
    }
    public function getDisplay()
    {
        return $this->display;
    }
}