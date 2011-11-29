<?php
// Base-2 logarithm of the iteration count used for password stretching
define('STRETCHING_TIMES', 8);
// Portability of hashing to older systems (less secure)
define('PORTABLE_HASH', false);
//Adding site root path to the include_path
define('ROOT', dirname(dirname(__FILE__)));
set_include_path(trim(get_include_path(), ':') . PATH_SEPARATOR . ROOT . DIRECTORY_SEPARATOR);

