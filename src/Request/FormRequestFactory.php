<?php

namespace Lucek\FormHandlerBundle\Request;

use Lucek\FormHandlerBundle\Exception\Form\Handler\FormInstanceErrorException;
use Lucek\FormHandlerBundle\Form\Handler\FormRequestHandler;
use Lucek\FormHandlerBundle\Repository\FormRequestRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class FormRequestFactory
 * @package Lucek\FormHandlerBundle\Request
 */
class FormRequestFactory
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormRequestHandler
     */
    private $handler;

    /**
     * @var FormRequestRepository
     */
    private $repository;

    /**
     * FormRequestFactory constructor.
     *
     * @param RouterInterface       $router
     * @param FormFactoryInterface  $formFactory
     * @param FormRequestHandler    $handler
     * @param FormRequestRepository $repository
     */
    public function __construct(RouterInterface $router, FormFactoryInterface $formFactory, FormRequestHandler $handler, FormRequestRepository $repository)
    {
        $this->router      = $router;
        $this->formFactory = $formFactory;
        $this->handler     = $handler;
        $this->repository  = $repository;
    }

    /**
     * @param string  $formClass
     * @param Request $request
     * @param null    $data
     *
     * @throws FormInstanceErrorException
     */
    public function create(string $formClass, Request $request, $data = null): void
    {
        if (false === class_exists($formClass)) {
            throw FormInstanceErrorException::missingClass($formClass);
        }

        if (false === is_a($formClass, AbstractType::class, true)) {
            throw FormInstanceErrorException::notInstanceOf(
                $formClass,
                AbstractType::class
            );
        }

        $this->repository->reset();

        $requestMethod = $request->getMethod();
        $form          = $this->formFactory->create(
            $formClass,
            $data,
            ['method' => $requestMethod]
        );
        $this->repository->setMethod($requestMethod);
        $this->repository->setFormInstance($form);
        $this->handler->apply($this->repository, $request);
    }
}
