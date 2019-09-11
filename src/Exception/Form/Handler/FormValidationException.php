<?php

namespace Lucek\FormHandlerBundle\Exception\Form\Handler;

/**
 * Class FormValidationException
 * @package Lucek\FormHandlerBundle\Exception\Form\Handler
 */
class FormValidationException extends FormInstanceErrorException
{
    /**
     * @return FormValidationException
     */
    public static function createForValidationError(): FormValidationException
    {
        return new FormValidationException('Provided data is invalid');
    }
}
