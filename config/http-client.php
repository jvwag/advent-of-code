<?php

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    ClientInterface::class => factory(static function (ContainerInterface $c) {
        $jar = CookieJar::fromArray([
            'session' => $c->get("session"),
        ], parse_url($c->get("base_uri"))["host"]);

        return new Client(["cookies" => $jar, "base_uri" => $c->get("base_uri")]);
    }),
];