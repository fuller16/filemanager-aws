<?php
// Minimal .env support
//
// - fm_load_env($path)  : parse a .env file once on bootstrap and push values
//                         into getenv() / $_ENV / $_SERVER. Existing real env
//                         vars are never overridden.
// - env($key, $default) : read a value with Laravel-style coercion of
//                         "true" / "false" / "null" / "empty" and stripping of
//                         surrounding quotes.

if (!function_exists('fm_load_env')) {
    function fm_load_env($path)
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            if (strpos($line, '=') === false) {
                continue;
            }
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if ($key === '') {
                continue;
            }
            // Real environment / pre-existing values always win
            if (getenv($key) !== false || isset($_ENV[$key]) || isset($_SERVER[$key])) {
                continue;
            }
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            if (isset($_ENV[$key])) { $value = $_ENV[$key]; }
            elseif (isset($_SERVER[$key])) { $value = $_SERVER[$key]; }
            else { return $default; }
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'null':
            case '(null)':
                return null;
            case 'empty':
            case '(empty)':
                return '';
        }

        $len = strlen($value);
        if ($len >= 2) {
            $first = $value[0];
            $last = $value[$len - 1];
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                return substr($value, 1, -1);
            }
        }

        if ($value === '') {
            return $default;
        }

        return $value;
    }
}
