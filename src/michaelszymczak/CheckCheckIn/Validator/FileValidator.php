<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use michaelszymczak\CheckCheckIn\View\ShellView;

class FileValidator {

    private $validator;
    private $viewForStatuses;
    private $viewForViolations;
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
        $this->viewForStatuses = ShellView::createInline();
        $this->viewForViolations = ShellView::createNewline();
    }
    public function validate($filename)
    {

        $this->validator->validate($filename);

        $output = "\n";
        foreach($this->validator->getStatusResponses() as $response) {
            $output .= $response->render($this->viewForStatuses) . " ";
        }
        $output .= "\n";
        foreach($this->validator->getViolationResponses() as $response) {
            $output .= $response->render($this->viewForViolations);
        }
        $output .= "\n";

        return $output;
    }
    public function areValid()
    {
        return $this->validator->areValid();
    }
    public function getValidator()
    {
        return $this->validator;
    }
}