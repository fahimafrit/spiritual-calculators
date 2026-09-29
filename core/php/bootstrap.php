<?php
declare(strict_types=1);

/* ════════════════════════════════════════════════════════════════════
   BOOTSTRAP
   Loaded first by every entry point. Defines the guard constant and
   the repository root, then loads the shared core files.
   ════════════════════════════════════════════════════════════════════ */

if (!defined('SPIRITUAL_APP')) {
    define('SPIRITUAL_APP', true);
}

define('SPIRITUAL_ROOT', dirname(__DIR__, 2));

if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

require_once __DIR__ . '/http.php';
require_once __DIR__ . '/registry.php';
require_once __DIR__ . '/dispatcher.php';