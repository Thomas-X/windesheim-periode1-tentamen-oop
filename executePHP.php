<?php
$port = 8000;
$eol = PHP_EOL;

// kinda misleading but
// if it crashes well, then this is incorrect, but since when the shell_exec command is ran the stdout gets redirected to said shell_exec output
// i cant be bothered to figure it out
//print_r("Server ready on port {$port} {$eol}");
shell_exec("php -S localhost:{$port} -t public/");

// to run phpdoc do:
// phpdoc -d ./src -t ./docs