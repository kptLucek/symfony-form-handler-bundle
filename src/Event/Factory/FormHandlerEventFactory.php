<?php

namespace Lucek\FormHandlerBundle\Event\Factory;

use Lucek\ControllerAnnotationReaderBundle\Event\PostAnnotationEvent;
use Lucek\FormHandlerBundle\Event\AbstractFormHandlerEvent;
use Lucek\FormHandlerBundle\Event\PostFormHandlerEvent;
use Lucek\FormHandlerBundle\Event\PreFormHandlerEvent;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormHandlerEventFactory
 * @package Lucek\FormHandlerBundle\Event\Factory
 */
class FormHandlerEventFactory
{
    /**
     * @param FormInterface $form
     * @param array         $validation
     *
     * @return AbstractFormHandlerEvent
     */
    public function createPre(FormInterface $form, array $validation = []): AbstractFormHandlerEvent
    {
        $event = new PreFormHandlerEvent();
        $event->setValidation($validation);
        $event->setForm($form);

        return $event;
    }
    /**
     * @param FormInterface $form
     * @param array         $validation
     *
     * @return AbstractFormHandlerEvent
     */
    public function createPost(FormInterface $form, array $validation = []): AbstractFormHandlerEvent
    {
        $event = new PostFormHandlerEvent();
        $event->setValidation($validation);
        $event->setForm($form);

        return $event;
    }
}
