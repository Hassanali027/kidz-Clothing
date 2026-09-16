<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PostExService
{
    public function createShipment(Order $order): array
    {
        $token = config('services.postex.token');
        $pickupAddressCode = config('services.postex.pickup_address_code');

        if (!$token || !$pickupAddressCode) {
            throw new RuntimeException('PostEx configuration is incomplete. Please add the API token and pickup address code.');
        }

        if ($order->postex_tracking_number) {
            throw new RuntimeException('A PostEx shipment already exists for this order.');
        }

        $items = max(1, (int) $order->items->sum('quantity'));
        $orderDetail = $order->items->map(function ($item) {
            $details = trim($item->product_name . ($item->size ? ' - ' . $item->size : '') . ($item->color ? ' - ' . $item->color : ''));

            return $details . ' x' . $item->quantity;
        })->implode(', ');

        $payload = [
            'cityName' => trim((string) $order->city),
            'customerName' => trim($order->first_name . ' ' . $order->last_name),
            'customerPhone' => preg_replace('/\D+/', '', (string) $order->phone),
            'deliveryAddress' => trim((string) $order->address),
            'invoiceDivision' => 1,
            'invoicePayment' => (float) $order->total_amount,
            'items' => $items,
            'orderDetail' => $orderDetail,
            'orderRefNumber' => $order->order_number,
            'orderType' => 'Normal',
            'transactionNotes' => 'Kidz Wear order ' . $order->order_number,
            'pickupAddressCode' => (string) $pickupAddressCode,
            'storeAddressCode' => (string) (config('services.postex.store_address_code') ?: $pickupAddressCode),
        ];

        $response = Http::timeout(20)
            ->acceptJson()
            ->withHeaders(['token' => $token])
            ->post(rtrim(config('services.postex.base_url'), '/') . '/v3/create-order', $payload);

        $body = $response->json();
        if (!$response->successful() || !is_array($body)) {
            throw new RuntimeException('PostEx could not create the shipment. ' . $this->message($body, $response->body()));
        }

        $trackingNumber = data_get($body, 'dist.trackingNumber')
            ?: data_get($body, 'dist.0.trackingNumber')
            ?: data_get($body, 'trackingNumber');

        if (!$trackingNumber) {
            throw new RuntimeException('PostEx did not return a tracking number. ' . $this->message($body));
        }

        return [
            'tracking_number' => trim((string) $trackingNumber),
            'status' => data_get($body, 'dist.orderStatus') ?: data_get($body, 'dist.0.orderStatus') ?: 'UnBooked',
        ];
    }

    private function message($body, $fallback = ''): string
    {
        if (is_array($body)) {
            return (string) (data_get($body, 'statusMessage') ?: data_get($body, 'message') ?: $fallback);
        }

        return (string) $fallback;
    }
}
