<?php

namespace Lucek\FormHandlerBundle\Event\Listener;

use Lucek\AnnotationReaderBundle\Event\AnnotationEvent;
use Lucek\FormHandlerBundle\Annotation\FormHandler;
use Lucek\FormHandlerBundle\Exception\Annotation\MultipleAnnotationException;

/**
 * Class FormHandlerMethodAnnotationListener
 * @package Lucek\FormHandlerBundle\Event\Listener
 */
class FormHandlerMethodAnnotationListener
{
    /**
     * @param AnnotationEvent $event
     *
     * @throws MultipleAnnotationException
     */
    public function onMethodAnnotation(AnnotationEvent $event): void
    {
        $annotation     = $event->getAnnotation();
        $methodMetadata = $event->getMethodMetadata();

        /** @var FormHandler $annotation */
        if (false === $annotation instanceof FormHandler) {
            return;
        }

        if (false === property_exists($methodMetadata, 'form')) {
            /** @noinspection PhpUndefinedFieldInspection */
            $methodMetadata->form = [];
        }

        if (false === property_exists($methodMetadata, 'data')) {
            /** @noinspection PhpUndefinedFieldInspection */
            $methodMetadata->data = [];
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $annotatedMethod = strtoupper($annotation->method);
        /** @noinspection PhpUndefinedFieldInspection */
        if (true === array_key_exists($annotatedMethod, $methodMetadata->form)) {
            /** @noinspection PhpUndefinedFieldInspection */
            throw MultipleAnnotationException::createForAnnotation(
                FormHandler::class,
                $annotatedMethod,
                1,
                count(
                    $methodMetadata->form
                )
            );
        }
        /** @noinspection PhpUndefinedFieldInspection */
        $methodMetadata->form[$annotatedMethod] = $annotation->form;
        /** @noinspection PhpUndefinedFieldInspection */
        $methodMetadata->data[$annotatedMethod] = $annotation->data;
    }
}
