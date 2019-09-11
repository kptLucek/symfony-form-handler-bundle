<?php

namespace Lucek\FormHandlerBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormHandler
 * @package Lucek\FormHandlerBundle\Annotation
 *
 * @Annotation
 * @Target("METHOD")
 */
class FormHandler
{
    /**
     * @Required()
     *
     * Form classname which should be handled, must be instance of AbstractType
     * @see AbstractType
     *
     * @var string
     */
    public $form;

    /**
     * @Required()
     * @Enum({"GET", "POST", "PUT", "PATCH"})
     *
     * Because of multiple @FormHandler annotation allowed, method need's to be specified for case, when method supports
     * multiple methods, like GET and POST.
     *
     * @var string
     */
    public $method;

    /**
     * Request attribute from where data should be provided
     *
     * @see Request
     * @see $request->attributes
     *
     * @var string
     */
    public $data;
}
