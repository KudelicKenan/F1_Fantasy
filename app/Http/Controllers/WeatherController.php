<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Get weather for a race location and update race record.
     */
    public function getWeatherForRace(Request $request, $raceId)
    {
        $race = Race::findOrFail($raceId);
        
        try {
            // Koristimo OpenWeatherMap API (besplatno)
            // Možete dobiti API key na https://openweathermap.org/api
            $apiKey = config('services.openweathermap.api_key');
            
            if (!$apiKey) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'error' => 'Weather API key nije konfigurisan. Dodajte WEATHER_API_KEY u .env fajl.'
                    ], 400);
                }
                return redirect()->route('races.show', $race->id)
                    ->with('error', 'Weather API key nije konfigurisan. Dodajte WEATHER_API_KEY u .env fajl.');
            }
            $url = "https://api.openweathermap.org/data/2.5/weather";
            
            // Try to get weather by city name
            $response = Http::timeout(10)->get($url, [
                'q' => $race->location,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'hr', // Croatian language for descriptions
            ]);
            
            // Log the request for debugging
            Log::info('Weather API request', [
                'location' => $race->location,
                'status' => $response->status(),
                'has_api_key' => !empty($apiKey),
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
                $weatherDescription = $weatherData['weather'][0]['description'] ?? 'Unknown';
                $temperature = $weatherData['main']['temp'] ?? null;
                
                // Update race with weather information
                $weatherString = $weatherDescription . ($temperature ? " ({$temperature}°C)" : '');
                $race->update([
                    'weather' => $weatherString,
                ]);

                // Return JSON for API requests
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'message' => 'Vremenske prilike su uspješno ažurirane',
                        'race' => $race->fresh(),
                        'weather' => [
                            'description' => $weatherDescription,
                            'temperature' => $temperature,
                            'full_description' => $weatherString,
                            'raw_data' => $weatherData
                        ]
                    ]);
                }

                return redirect()->route('races.show', $race->id)
                    ->with('success', 'Vremenske prilike su uspješno ažurirane: ' . $weatherString);
            } else {
                // Get error details from API response
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? 'Unknown error';
                $statusCode = $response->status();
                
                Log::error('Weather API error', [
                    'status' => $statusCode,
                    'response' => $errorData,
                    'location' => $race->location,
                ]);
                
                // Don't update race weather if API fails
                // Common error messages
                if ($statusCode == 401) {
                    $userMessage = "❌ Weather API key nije validan ili nije aktiviran.\n\nProvjerite:\n1. Da li je API key tačno kopiran u .env fajl (bez razmaka, bez navodnika)\n2. Da li je API key aktiviran na OpenWeatherMap (može potrajati do 2 sata nakon registracije)\n3. Da li ste koristili pravi API key sa OpenWeatherMap (ne API key iz drugog servisa)\n\nVidite detalje: https://openweathermap.org/faq#error401";
                } elseif ($statusCode == 404) {
                    $userMessage = "📍 Lokacija '{$race->location}' nije pronađena. Provjerite da li je naziv lokacije ispravan (npr. 'Monaco' umjesto 'Monaco, Monaco').";
                } elseif ($statusCode == 429) {
                    $userMessage = "⏱️ Previše zahtjeva ka Weather API-ju. Pokušajte ponovo kasnije.";
                } else {
                    $userMessage = "⚠️ Weather API greška (Status: {$statusCode}): {$errorMessage}";
                }
                
                // Return JSON for API requests
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'error' => $userMessage,
                        'status_code' => $statusCode,
                        'api_error' => $errorMessage
                    ], $statusCode);
                }
                
                return redirect()->route('races.show', $race->id)
                    ->with('error', $userMessage);
            }
        } catch (\Exception $e) {
            Log::error('Weather API error: ' . $e->getMessage());
            
            // Return JSON for API requests
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'error' => 'Greška pri dohvatanju vremenskih prilika',
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('races.show', $race->id)
                ->with('error', 'Greška pri dohvatanju vremenskih prilika: ' . $e->getMessage());
        }
    }

    /**
     * Update weather for all upcoming races.
     */
    public function updateAllRacesWeather()
    {
        $races = Race::where('race_date', '>=', now())
            ->whereNull('weather')
            ->orWhere('weather', '')
            ->get();

        $updated = 0;
        $failed = 0;

        foreach ($races as $race) {
            try {
                $this->getWeatherForRace($race->id);
                $updated++;
            } catch (\Exception $e) {
                $failed++;
                Log::error("Failed to update weather for race {$race->id}: " . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Weather update completed',
            'updated' => $updated,
            'failed' => $failed,
        ]);
    }
}
