<?php

namespace App\Http\Controllers;

use App\DTO\DatabaseInfoDTO;
use App\DTO\ClientInfoDTO;
use App\DTO\ServerInfoDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    // Получение информации о сервере (версия PHP)
    public function server()
    {
        // Получаем версию PHP
        $phpVersion = phpversion();
        
        // Создаем DTO с данными версии PHP
        $data = new ServerInfoDTO($phpVersion);

        // Возвращаем данные в формате JSON
        return response()->json($data);
    }

    // Получение информации о клиенте (IP и User-Agent)
    public function client(Request $request)
    {
        // Получаем IP клиента и его User-Agent
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        
        // Создаем DTO с данными клиента
        $data = new ClientInfoDTO($ip, $userAgent);

        // Возвращаем данные в формате JSON
        return response()->json($data);
    }

    // Получение информации о базе данных
    public function database()
    {
        try {
            // Получаем имя базы данных через фасад DB
            $dbName = DB::connection()->getDatabaseName();

            // Создаем DTO для базы данных
            $data = new DatabaseInfoDTO($dbName);

            // Возвращаем данные в формате JSON
            return response()->json($data);
        } catch (\Exception $e) {
            // В случае ошибки возвращаем сообщение об ошибке
            return response()->json(['error' => 'Unable to fetch database information'], 500);
        }
    }
}


