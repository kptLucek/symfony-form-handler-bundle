<?php
declare(strict_types=1);

namespace Lucek\FormHandlerBundle\Event;

use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AbstractFormHandlerEvent
 * Package Lucek\FormHandlerBundle\Event
 */
abstract class AbstractFormHandlerEvent extends Event
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var array
     */
    protected $validation;

    /**
     * FormHandlerEvent constructor.
     */
    public function __construct()
    {
        $this->validation = [];
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     *
     * @return AbstractFormHandlerEvent
     */
    public function setForm(FormInterface $form): AbstractFormHandlerEvent
    {
        $this->form = $form;

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
     * @return AbstractFormHandlerEvent
     */
    public function setValidation(array $validation = []): AbstractFormHandlerEvent
    {
        $this->validation = $validation;

        return $this;
    }
}
