<?php

namespace App\Http\Controllers;

use App\DTO\ServerInfoDTO;
use App\DTO\ClientInfoDTO;
use App\DTO\DatabaseInfoDTO;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function server()
    {
        $server_info = new ServerInfoDTO(phpversion());
        return response()->json($server_info);
    }

    public function client(Request $request)
    {
        $client_info = new ClientInfoDTO($request->ip(), $request->userAgent());
        return response()->json($client_info);
    }

    public function database()
    {
        $database_info = new DatabaseInfoDTO(env('DB_DATABASE'));
        return response()->json($database_info);
    }
}

