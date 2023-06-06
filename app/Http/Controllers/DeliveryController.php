<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public function sendContract(Request $request)
    {

        // Получение данных о посылке и получателе из запроса
        $parcelData = $request->only(['width', 'height', 'length', 'weight']);
        $customerData = $request->only(['customer_name', 'phone_number', 'email', 'delivery_address']);

        // Формирование данных для отправки на сервер Новой почты
        $requestData = [
            'customer_name' => $customerData['customer_name'],
            'phone_number' => $customerData['phone_number'],
            'email' => $customerData['email'],
            'sender_address' => config('app.sender_address'),
            'delivery_address' => $customerData['delivery_address']
        ];

        // Отправка данных на сервер Новой почты
        $response = Http::post('http://127.0.0.1:8001/api/novaposhta/delivery', $requestData);

        // Обработка ответа от сервера Новой почты
        if ($response->successful()) {
            return response()->json(['message' => 'Данные успешно отправлены на сервер Новой почты']);
        } else {
            return response()->json(['message' => 'Произошла ошибка при отправке данных на сервер Новой почты'], 500);
        }
    }
}
