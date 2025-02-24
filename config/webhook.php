<?php

return [
    'booking_notification_url' => env('BOOKING_NOTIFICATION_URL', 'https://api-example.com/webhook/booking'),
    'api_key' => env('BOOKING_NOTIFICATION_API_KEY', ''),
    'whatsapp_api_url' => env('WHATSAPP_API_URL', 'http://192.168.100.117:3000/send-message'),
    'whatsapp_recipient' => env('WHATSAPP_RECIPIENT', '628980619040@c.us'),
]; 