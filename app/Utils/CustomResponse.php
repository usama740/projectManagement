<?php

namespace App\Utils;

class CustomResponse {
    public static function send($status, $message, $data = [], $isDataShow=true) {
        $response_data = [
            "status" => $status,
            "message" => $message
        ];

        if ($isDataShow){
            $key = "entity";
            $count = count($data);
            if ($count > 1){
                $key = "entity_list";
            }
            $response_data[$key] = $data;
        }

        return $response_data;
    }
}
