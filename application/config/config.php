<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Are we using mod_rewrite (to generate "beautiful URLs) ? If so, set this to true. Default value is false.
 * Only change this value if you have successfully installed mod_rewrite and activated it in the Apache / Nginx configs.
 * @see XXXXXXXXXXXX
 * When MOD_REWRITE is true our URLs will look like: http://www.example.com/car/show/17
 * When MOD_REWRITE is false our URLs will look like: http://www.example.com/index.php/car/show/17
 */
define('MOD_REWRITE', false);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 * IMPORTANT: Your URL needs to have a trailing slash like "xxx.com/" !
 */
// TODO subfolder!
if (MOD_REWRITE) {
    define('URL', 'http://192.168.33.10/');
} else {
    define('URL', 'http://192.168.33.10/' . 'index.php/');
}

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'php-mvc');
define('DB_USER', 'root');
define('DB_PASS', 'mysql');
