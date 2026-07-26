<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

class HttpService
{
    private const NEWS_DOMAIN = 'newsapi.org';

    private const INTERNAL_DOMAIN = 'internal.finance';

    private Client $client;

    private string $refererHeader;

    public function __construct()
    {
        $this->refererHeader = config('app.url');

        $this->client = new Client([
            'connect_timeout' => 3,
            'timeout' => 5,
            'allow_redirects' => false,
        ]);
    }

    public function getRequest(string $url): string
    {
        $parsedUrl = parse_url($url);

        if (
            ! is_array($parsedUrl)
            || ! isset($parsedUrl['scheme'], $parsedUrl['host'])
            || isset($parsedUrl['user'], $parsedUrl['pass'])
        ) {
            return $this->errorResponse('Invalid URL.');
        }

        $scheme = strtolower($parsedUrl['scheme']);
        $host = strtolower($parsedUrl['host']);
        $path = $parsedUrl['path'] ?? '/';

        $options = [];

        if ($host === self::NEWS_DOMAIN) {
            if (
                $scheme !== 'https'
                || $path !== '/v2/top-headlines'
            ) {
                return $this->errorResponse('Destination not allowed.');
            }
        } elseif ($host === self::INTERNAL_DOMAIN) {
            /*
             * Il servizio finanziario interno è accessibile soltanto
             * dagli amministratori autenticati.
             */
            abort_unless(Auth::user()?->is_admin, 403);

            if (
                $scheme !== 'http'
                || ($parsedUrl['port'] ?? null) !== 8001
                || $path !== '/user-data.php'
            ) {
                return $this->errorResponse('Destination not allowed.');
            }

            $options['headers'] = [
                'Referer' => $this->refererHeader,
            ];
        } else {
            return $this->errorResponse('Destination not allowed.');
        }

        try {
            $response = $this->client->request('GET', $url, $options);

            return $response->getBody()->getContents();
        } catch (GuzzleException $exception) {
            return $this->errorResponse('Remote service unavailable.');
        }
    }

    private function errorResponse(string $message): string
    {
        return (string) json_encode([
            'error' => $message,
        ]);
    }
}
