<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class UkrposhtaDeliveryService implements DeliveryServiceInterface
{
    public function sendDeliveryData($contractData)
    {
        $response = Http::post('http://127.0.0.1:8001/api/ukrposhta/delivery', $contractData);
        
        if ($response->successful()) {
            return response()->json(['message' => 'Данные успешно отправлены на сервер Укр почты']);
        } else {
            return response()->json(['message' => 'Произошла ошибка при отправке данных на сервер Укр почты'], 500);
        }
    }
}
