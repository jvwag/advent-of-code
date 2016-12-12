# Advent of Code 2016

My personal implementation of this years [Advent of Code](http://adventofcode.com/2016).

Create a configuration for downloading the assignments:

1. Find the session cookie by using a debugger on your favorite browser after logging in on the [adventofcode.com](http://adventofcode.com) site. The cookie name is `session`. 
2. Copy `config/config.json.template` to `config/config.json`
3. Edit `config/config.json` and replace the `session` entry with the session cookie value 

Make sure the `downloads/` directory is writable.

Run an assignment using:

````
Usage:
  run [options] [--] [<day>]

Arguments:
  day                   Day of the assignment

Options:
      --year[=YEAR]     Year of the assignment [default: "2016"]
````

Example:
````
# php bin/console.php run 2
[2016-12-12 14:41:17] advent-of-code.INFO: Read assignment {"file":".../year2016-day2.txt","size":2356} []
33444
446A6
#
````
