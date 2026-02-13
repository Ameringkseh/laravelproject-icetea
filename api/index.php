<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Force Vercel Environment Configuration
|--------------------------------------------------------------------------
|
| We explicitly set the configuration here to ensure Vercel environment
| variables are used, bypassing any potential config caching or
| .env file loading issues.
|
*/

$app->useStoragePath('/tmp/storage');

// Force Database Configuration from Environment
if (getenv('DB_CONNECTION') === 'pgsql') {
    config([
        'database.default' => 'pgsql',
        'database.connections.pgsql.host' => getenv('DB_HOST'),
        'database.connections.pgsql.port' => getenv('DB_PORT'),
        'database.connections.pgsql.database' => getenv('DB_DATABASE'),
        'database.connections.pgsql.username' => getenv('DB_USERNAME'),
        'database.connections.pgsql.password' => getenv('DB_PASSWORD'),
        'database.connections.pgsql.sslmode' => getenv('DB_SSLMODE') ?: 'require',
    ]);
}

// Debug block (hidden by default)
if (isset($_GET['debug_env'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'Configuration Forced',
        'db_default' => config('database.default'),
        'db_host' => config('database.connections.pgsql.host'),
        'env_connection' => getenv('DB_CONNECTION'),
    ]);
    exit;
}

$app->handleRequest(Request::capture());
