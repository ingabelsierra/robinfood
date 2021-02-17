<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\User;

class ToolsHelper {

    public static function writeLog($request, $user_id, $event, $logType) {

        $client_ip = $request->getClientIp();
        $method = $request->method();
        $url = $request->fullUrl();
        $agent = $request->server('HTTP_USER_AGENT');

        $user = User::find($user_id);
        $name = $user->name;
        $lastname = $user->last_name;
        $email = $user->email;
        $fullname = $name.' '.$lastname; 

        Log::$logType('Evento: ' . $event . ' User id: ' . $user_id .' Nombre: '.$fullname. ' Email: '.$email.' Ip: ' . $client_ip . ' url: ' . $url . ' Metodo: ' . $method . ' Agent: ' . $agent);
    }

}
