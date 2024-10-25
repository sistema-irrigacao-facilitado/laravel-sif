<?php

namespace XLaravel\ValidationExtend\Rules;

use Illuminate\Contracts\Validation\Rule;

class HumanNameRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (bool)preg_match('/^[[:alpha:]][[:alpha:] \'&-]*[[:alpha:]]$/u', $value);
    }

    public function message(): string
    {
        return trans('X-Laravel::validationExtend.human_name');
    }
}
