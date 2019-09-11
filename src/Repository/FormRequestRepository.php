<?php

namespace Lucek\FormHandlerBundle\Repository;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormRequest
 * @package Lucek\FormHandlerBundle\Repository
 */
class FormRequestRepository
{
    /**
     * @var FormInterface|null
     */
    private $formInstance;

    /**
     * @var string|null
     */
    private $method;

    /**
     * @var mixed|null
     */
    private $data;

    /**
     * @var bool
     */
    private $submitted;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @var array
     */
    private $validation;

    /**
     * @var boolean
     */
    private $fresh;

    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        $this->fresh      = true;
        $this->valid      = true;
        $this->submitted  = false;
        $this->validation = [];
        $this->method     = Request::METHOD_GET;
    }

    /**
     * @return FormInterface|null
     */
    public function getFormInstance(): ?FormInterface
    {
        return $this->formInstance;
    }

    /**
     * @param FormInterface $formInstance
     *
     * @return FormRequestRepository
     */
    public function setFormInstance(FormInterface $formInstance): FormRequestRepository
    {
        $this->fresh        = false;
        $this->formInstance = $formInstance;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return FormRequestRepository
     */
    public function setMethod(string $method): FormRequestRepository
    {
        $this->fresh  = false;
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed|null $data
     *
     * @return FormRequestRepository
     */
    public function setData($data = null): FormRequestRepository
    {
        $this->fresh = false;
        $this->data  = $data;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @param bool $submitted
     *
     * @return FormRequestRepository
     */
    public function setSubmitted(bool $submitted): FormRequestRepository
    {
        $this->fresh     = false;
        $this->submitted = $submitted;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     *
     * @return FormRequestRepository
     */
    public function setValid(bool $valid): FormRequestRepository
    {
        $this->fresh = false;
        $this->valid = $valid;

        return $this;
    }

    /**
     * @return array
     */
    public function getValidation(): array
    {
        return $this->validation;
    }

    /**
     * @param array $validation
     *
     * @return FormRequestRepository
     */
    public function setValidation(array $validation): FormRequestRepository
    {
        $this->fresh      = false;
        $this->validation = $validation;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFresh(): bool
    {
        return $this->fresh;
    }

    public function reset(): void
    {
        $this->fresh      = true;
        $this->data       = null;
        $this->method     = null;
        $this->submitted  = false;
        $this->valid      = true;
        $this->validation = [];
    }
}
