<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function DI\factory;

return [
    LoggerInterface::class => factory(static function(ContainerInterface $c) {
        $logger = new Logger($c->get("application.name"));
        $logger->pushHandler(new StreamHandler("php://stdout"));

        return $logger;
    }),
];
