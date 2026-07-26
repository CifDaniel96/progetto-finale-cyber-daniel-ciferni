<?php

namespace App\Livewire;

use App\Services\HttpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LatestNews extends Component
{
    public string $selectedCountry = '';

    public array $news = [];

    public function fetchNews(): void
    {
        /*
         * La pagina è destinata ai writer, ma il controllo viene
         * ripetuto lato server perché l'azione Livewire è invocabile
         * tramite una richiesta HTTP.
         */
        abort_unless(Auth::user()?->is_writer, 403);

        $validated = $this->validate([
            'selectedCountry' => [
                'required',
                Rule::in(['it', 'gb', 'us']),
            ],
        ]);

        $apiKey = config('services.newsapi.api_key');

        if (blank($apiKey)) {
            $this->news = [
                'error' => 'News service is not configured.',
            ];

            return;
        }

        /*
         * Il browser invia soltanto il codice del Paese.
         * Host, percorso e API key vengono costruiti dal server.
         */
        $query = http_build_query([
            'country' => $validated['selectedCountry'],
            'apiKey' => $apiKey,
        ]);

        $url = "https://newsapi.org/v2/top-headlines?{$query}";

        $response = app(HttpService::class)->getRequest($url);
        $decodedResponse = json_decode($response, true);

        $this->news = is_array($decodedResponse)
            ? $decodedResponse
            : ['error' => 'Invalid response from news service.'];
    }

    public function render()
    {
        return view('livewire.latest-news');
    }
}