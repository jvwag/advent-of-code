<?php

function getAssignment($dir, $day)
{
    $session = "xxx";
    $url = "http://adventofcode.com/2016/day/" . $day . "/input";
    $file = $dir . DIRECTORY_SEPARATOR . "day" . $day . ".txt";

    if (!file_exists($file) || !filesize($file)) {

        $context = stream_context_create([
            'http' => [
                'header' => "Cookie: session=" . $session,
            ],
        ]);

        $input = file_get_contents($url, null, $context);
        file_put_contents($file, $input);
        var_dump($input);
    }
}

