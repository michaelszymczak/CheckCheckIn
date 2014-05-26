<?php
namespace michaelszymczak\CheckCheckIn\Validator;

use michaelszymczak\CheckCheckIn\Command\Executor\BadNewsOnlyExecutor;

class ValidatorTemplateFactory {
    public function create($patterns)
    {
        return new ValidatorTemplate(new Validator(new BadNewsOnlyExecutor(), $patterns));
    }
}