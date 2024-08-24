<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class APIController extends Controller
{
    public static function index() {
        $data = [
            'db_connection' => Schema::hasTable('products'),
            'uptime' => shell_exec('uptime -p'),
            'last_import_time' => Cache::get('last_cronjob_execution') == null ? "Não executado ainda" : (new \DateTime(Cache::get('last_cronjob_execution')))->format('d-m-Y H:i:s'),
            'memory_usage' => strval( memory_get_usage() / 1000000) . ' MB' // Converte para Megabytes
        ];

        return response()->json(['success' => true, 'content' => $data]);
    }
}
