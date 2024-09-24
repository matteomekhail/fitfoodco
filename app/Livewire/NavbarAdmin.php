<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NavbarAdmin extends Component
{
    public function render()
    {
        return view('livewire.navbar-admin');
    }
    public function export()
    {
        // Definire l'header per un download diretto
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        // Creare la response e aggiungere gli header
        $response = new StreamedResponse(function () {
            // Aprire PHP output stream
            $handle = fopen('php://output', 'w');

            // Aggiungere l'intestazione del file CSV
            fputcsv($handle, ['email']);

            // Estrarre e scrivere i dati
            DB::table('users')->orderBy('id')->chunk(100, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [$user->email]);
                }
            });

            // Chiudere il file stream
            fclose($handle);
        }, 200, $headers);

        // Imposta l'opzione X-Accel-Buffering su no per evitare buffering
        $response->headers->set('X-Accel-Buffering', 'no');

        // Imposta il timeout per la risposta
        set_time_limit(0);

        // Restituire la response per il download
        return $response;
    }
}
