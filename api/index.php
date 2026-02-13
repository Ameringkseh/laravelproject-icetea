<?php
/**
 * Vercel serverless function entry point.
 * Creates required /tmp directories for Laravel on serverless.
 */

// Debug: Enable full error reporting temporarily
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure /tmp directories exist for serverless environment
$tmpDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/framework/views',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

try {
    require __DIR__.'/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Vercel PHP Error</h1>";
    echo "<pre>" . $e . "</pre>";
    if (file_exists('/tmp/laravel-error.log')) {
        echo "<h2>Log File:</h2><pre>" . file_get_contents('/tmp/laravel-error.log') . "</pre>";
    }
}
