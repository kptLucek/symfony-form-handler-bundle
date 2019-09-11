<?php

namespace Lucek\FormHandlerBundle\Form\Handler;

use Lucek\FormHandlerBundle\Event\Factory\FormHandlerEventFactory;
use Lucek\FormHandlerBundle\Event\FormHandlerEvents;
use Lucek\FormHandlerBundle\Exception\Form\Handler\FormInstanceErrorException;
use Lucek\FormHandlerBundle\Form\Validation\FormValidationExtractor;
use Lucek\FormHandlerBundle\Repository\FormRequestRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormRequestHandler
 * @package Lucek\FormHandlerBundle\Form\Handler
 */
class FormRequestHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var FormHandlerEventFactory
     */
    private $factory;

    /**
     * @var FormValidationExtractor
     */
    private $validationExtractor;

    /**
     * FormRequestHandler constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param FormHandlerEventFactory  $factory
     * @param FormValidationExtractor  $validationExtractor
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormHandlerEventFactory $factory, FormValidationExtractor $validationExtractor)
    {
        $this->eventDispatcher     = $eventDispatcher;
        $this->factory             = $factory;
        $this->validationExtractor = $validationExtractor;
    }

    /**
     * @param FormRequestRepository $formRequest
     * @param Request               $request
     *
     * @throws FormInstanceErrorException
     */
    public function apply(FormRequestRepository $formRequest, Request $request): void
    {
        $form = $formRequest->getFormInstance();
        if (null === $form) {
            throw FormInstanceErrorException::formNotPresent();
        }
        $validation = [];
        $this->eventDispatcher->dispatch($this->factory->createPre($form, $validation));
        $form->handleRequest($request);
        if (false === $form->isSubmitted()) {
            $requestData = $request->request->all();
            if (Request::METHOD_GET === $request->getMethod()) {
                $requestData = $request->query->all();
            }
            $form->submit($requestData);
        }
        $formValid = $form->isValid();
        $formRequest->setSubmitted(true);
        $formRequest->setData($form->getData());
        $formRequest->setValid($formValid);
        if (false === $formValid) {
            $validation = $this->validationExtractor->extract($form);
        }
        $formRequest->setValidation($validation);
        $this->eventDispatcher->dispatch($this->factory->createPost($form, $validation));
    }
}
