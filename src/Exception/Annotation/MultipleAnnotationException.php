<?php

namespace Lucek\FormHandlerBundle\Exception\Annotation;

use Lucek\FormHandlerBundle\Exception\ApiCoreException;

/**
 * Class MultipleAnnotationException
 * @package Lucek\FormHandlerBundle\Exception\Annotation
 */
class MultipleAnnotationException extends ApiCoreException
{
    /**
     * @param string $class
     * @param string $method
     * @param int    $max
     * @param int    $current
     *
     * @return MultipleAnnotationException
     */
    public static function createForAnnotation(string $class, string $method, int $max = 1, int $current = 1): MultipleAnnotationException
    {
        $message = sprintf(
            'Annotation "%s" was not expected to be present more than %d times for method "%s", %d present',
            $class,
            $max,
            $method,
            $current
        );

        return new MultipleAnnotationException($message);
    }
}
