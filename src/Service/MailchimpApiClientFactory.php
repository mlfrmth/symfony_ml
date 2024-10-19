<?php

namespace App\Service;

use MailchimpMarketing\ApiClient;

final class MailchimpApiClientFactory
{
    public static function create(string $apiKey): ApiClient
    {
        $client = new ApiClient();
        $keyAndServer = self::extractKeyAndServer($apiKey);

        $client->setConfig([
            'apiKey' => $keyAndServer['key'],
            'server' => $keyAndServer['server'],
        ]);

        return $client;
    }

    public static function extractKeyAndServer(string $fullKey): array
    {
        $keyAndDataCenter = explode("-", $fullKey);

        return [
            'key' => $keyAndDataCenter[0],
            'server' => $keyAndDataCenter[1],
        ];
    }
}
