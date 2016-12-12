<?php

namespace jvwag\AdventOfCode;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class DIContainer extends ContainerBuilder
{
    public static function buildContainer($root)
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
