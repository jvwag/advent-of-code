<?php

namespace jvwag\AdventOfCode;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class DIContainer
 *
 * @package jvwag\AdventOfCode
 */
class DIContainer extends ContainerBuilder
{
    /**
     * @param $root
     *
     * @return DIContainer
     * @throws \Exception
     */
    public static function buildContainer($root): DIContainer
    {
        $container = new self();
        $container->setParameter("root", $root);
        $loader = new PhpFileLoader(
            $container,
            new FileLocator($root . "/config")
        );
        $loader->load("services.php");
        $container->compile();

        return $container;
    }
}
