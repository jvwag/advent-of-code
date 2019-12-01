# Advent of Code

My personal implementation of this [Advent of Code](https://adventofcode.com).

Create a configuration for downloading the assignments:

1. Find the session cookie by using a debugger on your favorite browser after logging in on the [adventofcode.com](https://adventofcode.com) site. The cookie name is `session`. 
2. Edit `config/overrides.php` and replace the `session` entry with the session cookie value 

Make sure the `downloads/` directory is writable.

Run an assignment using:

````
Usage:
  run [options] [--] [<day>]

Arguments:
  day                   Day of the assignment

Options:
      --year[=YEAR]     Year of the assignment [default: current year]
````

Example:
````
# php bin/console.php run 2
[2017-12-02 23:01:28] advent-of-code.INFO: Read assignment {"file":"...\\year2017-day1.txt","size":2131} []
Answer day 1 of 2017, part 1:
1228
Answer day 1 of 2017, part 2:
1238
````