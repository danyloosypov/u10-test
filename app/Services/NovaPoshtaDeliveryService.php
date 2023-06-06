<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class NovaPoshtaDeliveryService implements DeliveryServiceInterface
{
    public function sendDeliveryData($completeContractData)
    {

        $contractData = [
            'customer_name' => $completeContractData['customerData']['customer_name'],
            'phone_number' => $completeContractData['customerData']['phone_number'],
            'email' => $completeContractData['customerData']['email'],
            'delivery_address' => $completeContractData['customerData']['delivery_address'],
            'sender_address' => $completeContractData['sender_address'],
        ];

        $response = Http::post('http://127.0.0.1:8001/api/novaposhta/delivery', $contractData);
        
        if ($response->successful()) {
            return response()->json(['message' => 'Данные успешно отправлены на сервер Новой почты']);
        } else {
            return response()->json(['message' => 'Произошла ошибка при отправке данных на сервер Новой почты'], 500);
        }
    }
}
