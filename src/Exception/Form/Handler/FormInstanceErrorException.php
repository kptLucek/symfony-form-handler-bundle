<?php

namespace Lucek\FormHandlerBundle\Exception\Form\Handler;

use Lucek\FormHandlerBundle\Exception\Form\ApiFormException;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormInstanceError
 * @package Lucek\FormHandlerBundle\Exception\Form\Handler
 */
class FormInstanceErrorException extends ApiFormException
{
    /**
     * @param string $class
     *
     * @return FormInstanceErrorException
     */
    public static function missingClass(string $class): FormInstanceErrorException
    {
        return new FormInstanceErrorException(
            sprintf('Class "%s" was not found.', $class)
        );
    }

    /**
     * @param string $class
     * @param string $expected
     *
     * @return FormInstanceErrorException
     */
    public static function notInstanceOf(string $class, string $expected): FormInstanceErrorException
    {
        return new FormInstanceErrorException(
            sprintf('Class "%s" is not an instance of "%s".', $class, $expected)
        );
    }

    /**
     * @return FormInstanceErrorException
     */
    public static function formNotPresent(): FormInstanceErrorException
    {
        return new FormInstanceErrorException(
            'Instance of "%s" was not found in model.',
            FormInterface::class
        );
    }
}
