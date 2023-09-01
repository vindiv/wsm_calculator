<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XMLController extends Controller
{
    public function caricaXML(Request $request)
{
    // Verifica se è stato caricato un file
    if ($request->hasFile('file_xml')) {
        $file = $request->file('file_xml');

        // Verifica se il file è un XML valido
        if ($file->getClientOriginalExtension() === 'xml') {
            $xml = simplexml_load_file($file);
            
            $skills = [
                'tiro' => (int)$xml->player->skills->tiro,
                'velocita' => (int)$xml->player->skills->velo,
                'passaggio' => (int)$xml->player->skills->pass,
                'tecnica' => (int)$xml->player->skills->tecn,
                'creativita' => (int)$xml->player->skills->crea,
                'contrasto' => (int)$xml->player->skills->cont,
                'resistenza' => (int)$xml->player->skills->resi,
                'colpo_di_testa' => (int)$xml->player->skills->test,
                'tattica' => (int)$xml->player->skills->tatt,
                'gioco_di_squadra' => (int)$xml->player->skills->gsqu,
                'posizione' => (int)$xml->player->skills->posi,
                'marcatura' => (int)$xml->player->skills->marc,
                'acrobazia' => (int)$xml->player->skills->acro,
                'dribbling' => (int)$xml->player->skills->drib,
                'continuita' => (int)$xml->player->skills->cost,
                'determinazione' => (int)$xml->player->skills->dete,
                'carisma' => (int)$xml->player->skills->cari,
                'impegno' => (int)$xml->player->skills->impe,
                'correttezza' => (int)$xml->player->skills->corr,
                'duttilita' => (int)$xml->player->skills->dutt,
                'punizioni' => (int)$xml->player->skills->puni,
                'rigori' => (int)$xml->player->skills->rigo,
            ];

            $nome = ['nome' => trim((string)$xml->player->name), 'cognome' => trim((string)$xml->player->surname)];

            $ruoli = [                
                'cc' => ($skills["velocita"] + $skills["resistenza"] + $skills["contrasto"] + $skills["posizione"] + $skills["tattica"] + $skills["gioco_di_squadra"] + $skills["tiro"] + $skills["passaggio"] + $skills["tecnica"]) / 9,
                'tc' => ($skills["tiro"] + $skills["passaggio"] + $skills["tecnica"] + $skills["creativita"] + $skills["dribbling"]) / 5,
                'al' => ($skills["velocita"] + $skills["passaggio"] + $skills["creativita"] + $skills["dribbling"]) / 4,
                'ac' => ($skills["tiro"] + $skills["velocita"] + $skills["tecnica"] + $skills["creativita"] + $skills["dribbling"] + $skills["colpo_di_testa"] + $skills["acrobazia"] + $skills["posizione"]) / 8
            ];

            $ruoli_specifici = [];

            $stili = [];

            $calcolo = ['nome' => $nome, 'ruoli' => $ruoli, 'ruoli_specifici' => $ruoli_specifici, 'stili' => $stili];

            
            // Restituisci la vista con i risultati
            return view('risultati', compact('calcolo'));
        } else {
            // Gestisci il caso in cui il file non sia un XML valido
            return redirect()->back()->with('error', 'Il file deve essere un XML valido.');
        }
    } else {
        // Gestisci il caso in cui nessun file sia stato caricato
        return redirect()->back()->with('error', 'Devi caricare un file XML.');
    }
}
}
