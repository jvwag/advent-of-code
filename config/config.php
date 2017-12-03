<?php

if (!file_exists(__DIR__ . "/config.json")) {
    throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException("Configuration file (config/config.json) not found");
}

$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);

if (!isset($config["session"]) || $config["session"] === "<-enter-your-session-here->") {
    throw new InvalidArgumentException("Configuration file does not contain a valid session key");
}

if (!isset($config["year"])) {
    $config["year"] = date("Y");
}

return $config;