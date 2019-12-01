<?php

return [
    "session" => "",

    // From December use this years date, otherwise we use last years date...
    "year" => date("m") < 12 ? date("Y") - 1 : date("Y"),

    "base_uri" => "http://adventofcode.com",
];