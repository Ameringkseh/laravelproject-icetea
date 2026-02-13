<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Forcefully Remove Cached Config files if they exist (to fix stale build cache)
$cachedConfig = __DIR__.'/../bootstrap/cache/config.php';
if (file_exists($cachedConfig)) {
    @unlink($cachedConfig);
}

// Force Postgres via Environment Variables
// We set these BEFORE bootstrap so LoadEnvironmentVariables sees them
if (getenv('DB_CONNECTION') !== 'pgsql') {
    putenv('DB_CONNECTION=pgsql');
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $_SERVER['DB_CONNECTION'] = 'pgsql';
}

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Configure Vercel Environment
|--------------------------------------------------------------------------
*/

$app->useStoragePath('/tmp/storage');

// DETECT WRONG CONFIGURATION (Local DB imported by mistake)
// Use getenv() and $_ENV to catch all possibilities
$dbHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? '');
$dbDatabase = getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? ''); 

if ($dbDatabase === 'db_icetea' || $dbHost === '127.0.0.1' || $dbHost === 'localhost') {
    http_response_code(500);
    die("
    <div style='font-family: sans-serif; padding: 2rem; max-width: 600px; margin: 0 auto; border: 2px solid red; border-radius: 8px; background: #fff0f0;'>
        <h1 style='color: red;'>⚠️ KONFIGURASI SALAH (WRONG CONFIG)</h1>
        <p>Aplikasi mencoba connect ke database LOKAL: <strong>$dbDatabase</strong> di <strong>$dbHost</strong>.</p>
        <p>Ini berarti Anda meng-import file <code>.env</code> computer Anda ke Vercel atau ada cache konfigurasi lama.</p>
        <hr>
        <h3>SOLUSI:</h3>
        <p>Silakan ke Vercel Dashboard → Settings → Environment Variables:</p>
        <ol>
            <li>HAPUS SEMUA variable yang ada sekarang.</li>
            <li>Import ulang file <code>.env.vercel</code> yang sudah saya buatkan (ada di folder project Anda).</li>
            <li>Pastikan <code>DB_CONNECTION=pgsql</code> dan <code>DB_HOST=...neon.tech...</code></li>
        </ol>
        <p>Saya sudah mencoba menghapus cache konfigurasi secara otomatis. Silakan refresh halaman ini sekarang.</p>
    </div>
    ");
}

$app->handleRequest(Request::capture());
