<?php

namespace Lucek\FormHandlerBundle\Reflection;

/**
 * Class ReflectionObjectFactory
 * @package Lucek\FormHandlerBundle\Reflection
 */
class ReflectionObjectFactory
{
    /**
     * @param callable $callable
     *
     * @return \ReflectionObject
     */
    public function create(callable $callable): \ReflectionObject
    {
        return new \ReflectionObject($callable);
    }
}
