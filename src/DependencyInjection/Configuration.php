<?php

namespace Lucek\FormHandlerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Lucek\FormHandlerBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('form_handler');
        $rootNode    = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
