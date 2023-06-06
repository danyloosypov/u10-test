<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\NovaPoshtaDeliveryService;
use App\Services\UkrposhtaDeliveryService;

class DeliveryController extends Controller
{
    public function sendContract(Request $request)
    {
        $parcelData = $request->only(['width', 'height', 'length', 'weight']);
        $customerData = $request->only(['customer_name', 'phone_number', 'email', 'delivery_address']);
        $deliveryServiceName = $request->input('delivery_service');

        $contractData = [
            'parcelData' => $parcelData,
            'customerData' => $customerData,
            'sender_address' => config('app.sender_address')
        ];

         $deliveryService = null;

         switch ($deliveryServiceName) {
             case 'nova_poshta':
                 $deliveryService = new NovaPoshtaDeliveryService();
                 break;
             case 'ukrposhta':
                 $deliveryService = new UkrposhtaDeliveryService();
                 break;
             
             default:
                 return response()->json(['message' => 'Неподдерживаемая служба доставки'], 400);
         }
 
         $response = $deliveryService->sendDeliveryData($contractData);
 
         if ($response->getStatusCode() === 200) {
             return response()->json(['message' => 'Данные успешно отправлены на сервер доставки']);
         } else {
             return response()->json(['message' => 'Произошла ошибка при отправке данных на сервер доставки'], 500);
         }
    }
}
