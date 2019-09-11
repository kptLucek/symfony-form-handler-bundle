<?php

namespace Lucek\FormHandlerBundle\Event\Listener;

use Lucek\ControllerAnnotationReaderBundle\Event\PostAnnotationEvent;
use Lucek\FormHandlerBundle\Exception\Form\Handler\FormInstanceErrorException;
use Lucek\FormHandlerBundle\Request\FormRequestFactory;

/**
 * Class ApplyFormPostAnnotationListener
 * @package Lucek\FormHandlerBundle\Event\Listener
 */
class ApplyFormPostAnnotationListener
{
    /**
     * @var FormRequestFactory
     */
    private $requestFactory;

    /**
     * ApplyFormPostAnnotationListener constructor.
     *
     * @param FormRequestFactory $requestFactory
     */
    public function __construct(FormRequestFactory $requestFactory)
    {
        $this->requestFactory = $requestFactory;
    }

    /**
     * @param PostAnnotationEvent $event
     *
     * @throws FormInstanceErrorException
     */
    public function postAnnotation(PostAnnotationEvent $event): void
    {
        $request          = $event->getRequest();
        $metadata         = $event->getMethodMetadata();
        $requestMethod    = strtoupper($request->getMethod());

        if (false === property_exists($metadata, 'form') || false === property_exists(
                $metadata,
                'data'
            )) {
            return;
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $forms = $metadata->form;
        /** @noinspection PhpUndefinedFieldInspection */
        $dataVariableKey = $metadata->data[$requestMethod];
        $data            = null;
        if (0 === count($forms) || false === array_key_exists($requestMethod, $forms)) {
            return;
        }

        if (false === empty($dataVariableKey)) {
            $data = $request->attributes->get($dataVariableKey);
        }

        $this->requestFactory->create($forms[$requestMethod], $request, $event->$data);
    }
}
