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
| Configure Vercel Environment & Force Postgres
|--------------------------------------------------------------------------
*/

$app->useStoragePath('/tmp/storage');

// DETECT WRONG CONFIGURATION (Local DB imported by mistake)
$dbHost = getenv('DB_HOST');
$dbDatabase = getenv('DB_DATABASE'); // e.g. 'db_icetea'

if ($dbDatabase === 'db_icetea' || $dbHost === '127.0.0.1' || $dbHost === 'localhost') {
    http_response_code(500);
    die("
    <div style='font-family: sans-serif; padding: 2rem; max-width: 600px; margin: 0 auto; border: 2px solid red; border-radius: 8px; background: #fff0f0;'>
        <h1 style='color: red;'>⚠️ KONFIGURASI SALAH (WRONG CONFIG)</h1>
        <p>Aplikasi mencoba connect ke database LOKAL: <strong>$dbDatabase</strong> di <strong>$dbHost</strong>.</p>
        <p>Ini berarti Anda meng-import file <code>.env</code> computer Anda ke Vercel.</p>
        <hr>
        <h3>JANGAN MEMAKAI FILE .env DARI LAPTOP ANDA!</h3>
        <p>Silakan ke Vercel Dashboard → Settings → Environment Variables:</p>
        <ol>
            <li>HAPUS SEMUA variable yang ada sekarang.</li>
            <li>Import ulang file <code>.env.vercel</code> yang sudah saya buatkan (ada di folder project Anda).</li>
            <li>Pastikan <code>DB_CONNECTION=pgsql</code> dan <code>DB_HOST=...neon.tech...</code></li>
        </ol>
        <p>Setelah diperbaiki, lakukan Redeploy.</p>
    </div>
    ");
}

// Force Postgres Config if needed
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

$app->handleRequest(Request::capture());
