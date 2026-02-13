<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// DEBUG: Check Environment Variables (moved after app creation to access config())
if (isset($_GET['debug_env'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'getenv_DB_CONNECTION' => getenv('DB_CONNECTION'),
        'getenv_DB_HOST' => getenv('DB_HOST'),
        'config_database_default' => config('database.default'),
        'config_connections_pgsql_host' => config('database.connections.pgsql.host'),
        'config_connections_mysql_host' => config('database.connections.mysql.host'),
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Configure Vercel Environment
|--------------------------------------------------------------------------
*/

$app->useStoragePath('/tmp/storage');

$app->handleRequest(Request::capture());
