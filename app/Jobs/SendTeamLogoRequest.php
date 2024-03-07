<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTeamLogoRequest implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $teamIds;
    protected $teamLogos;
    protected $teamId;

    public function __construct($teamIds, $teamLogos, $teamId)
    {
        $this->teamIds = $teamIds;
        $this->teamLogos = $teamLogos;
        $this->teamId = $teamId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $teamIds = $this->teamIds;
        $teamLogos = $this->teamLogos;
        $teamId = $this->teamId;

        $rateLimit = 1; // Broj zahtjeva u sekundi, prilagodite prema ograničenjima vašeg plana
        $teamLogos = [];

        // Kreirajte instancu Guzzle HTTP klijenta
        $client = new Client();

        foreach ($teamIds as $teamId) {
            // Prilagodite brzinu slanja zahtjeva prema ograničenjima
            usleep(1000000 / $rateLimit); // Pauzirajte na određeni interval pre svakog zahteva

            $teamLogoResponse = $client->request('GET', 'https://sofasport.p.rapidapi.com/v1/teams/logo', [
                'headers' => [
                    'X-RapidAPI-Key' => '5815fc42c9msh73f3079e4d4c18ap1a1fa8jsnb9b50db354f6',
                    'X-RapidAPI-Host' => 'sofasport.p.rapidapi.com',
                ],
                'query' => [
                    'team_id' => $teamId,
                ],
            ]);

            $teamLogoData = $teamLogoResponse->getBody()->getContents();
            $teamBase64Logo = 'data:image/png;base64,' . base64_encode($teamLogoData);

            $teamLogos[$teamId] = $teamBase64Logo;
        }

        // Ovde možete koristiti $teamIds, $teamLogos i $teamId za slanje zahteva za logo tima
    }
}
