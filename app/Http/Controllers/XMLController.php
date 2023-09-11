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
                'p' => '',
                'l' => ($skills['contrasto'] + $skills['colpo_di_testa'] + $skills['gioco_di_squadra'] + $skills['posizione'] + $skills['tattica']) / 5,
                'dc' => ($skills['velocita'] + $skills['contrasto'] + $skills['colpo_di_testa'] + $skills['acrobazia'] + $skills['marcatura'] + $skills['posizione']) / 6,
                'dl' => ($skills['velocita'] + $skills['contrasto'] + $skills['marcatura'] + $skills['posizione']) / 4,                            
                'mc' => ($skills['resistenza'] + $skills['contrasto'] + $skills['marcatura'] + $skills['posizione'] + $skills['tattica'] + $skills['passaggio']) / 6,
                'ml' => ($skills['velocita'] + $skills['contrasto'] + $skills['marcatura'] + $skills['passaggio']) / 4,                            
                'cc' => ($skills["velocita"] + $skills["resistenza"] + $skills["contrasto"] + $skills["posizione"] + $skills["tattica"] + $skills["gioco_di_squadra"] + $skills["tiro"] + $skills["passaggio"] + $skills["tecnica"]) / 9,
                'cl' => ($skills['velocita'] + $skills['gioco_di_squadra'] + $skills['tiro'] + $skills['passaggio'] + $skills['tecnica'] + $skills['dribbling']) / 6,
                'tc' => ($skills["tiro"] + $skills["passaggio"] + $skills["tecnica"] + $skills["creativita"] + $skills["dribbling"]) / 5,
                'tl' => ($skills['velocita'] + $skills['passaggio'] + $skills['creativita'] + $skills['dribbling']) / 4,               
                'ac' => ($skills["tiro"] + $skills["velocita"] + $skills["tecnica"] + $skills["creativita"] + $skills["dribbling"] + $skills["colpo_di_testa"] + $skills["acrobazia"] + $skills["posizione"]) / 8,
                'al' => ($skills["velocita"] + $skills["passaggio"] + $skills["creativita"] + $skills["dribbling"]) / 4
            ];

            $fluidificante = ($skills['velocita'] + $skills['passaggio'] + $skills['tecnica'] + $skills['creativita'] + $skills['resistenza'] + $skills['gioco_di_squadra'] + $skills['dribbling']) / 7;
            $marcatore = ($skills['velocita'] + $skills['contrasto'] + $skills['colpo_di_testa'] + $skills['tattica'] + $skills['posizione'] + $skills['marcatura'] + $skills['acrobazia']) / 7;
            $interditore = ($skills['velocita'] + $skills['contrasto'] + $skills['resistenza'] + $skills['tattica'] + $skills['posizione']) / 5;
            $registaDifensivo = ($skills['passaggio'] + $skills['tecnica'] + $skills['creativita'] + $skills['tattica'] + $skills['gioco_di_squadra'] + $skills['dribbling']) / 6;
            $regista = ($skills['passaggio'] + $skills['tecnica'] + $skills['creativita'] + $skills['tattica'] + $skills['gioco_di_squadra'] + $skills['dribbling']) / 6;
            $interno = ($skills['tiro'] + $skills['velocita'] + $skills['tecnica'] + $skills['creativita'] + $skills['colpo_di_testa'] + $skills['dribbling']) / 6;
            $fantasista = ($skills['tiro'] + $skills['passaggio'] + $skills['tecnica'] + $skills['creativita'] + $skills['dribbling']) / 5;
            $ala = ($skills['velocita'] + $skills['passaggio'] + $skills['tecnica'] + $skills['contrasto'] + $skills['resistenza'] + $skills['gioco_di_squadra'] + $skills['posizione'] + $skills['dribbling']) / 8;
            $secondaPunta = ($skills['tiro'] + $skills['velocita'] + $skills['passaggio'] + $skills['tecnica'] + $skills['creativita'] + $skills['resistenza'] + $skills['posizione'] + $skills['dribbling']) / 8;
            $pivot = ($skills['passaggio'] + $skills['contrasto'] + $skills['resistenza'] + $skills['colpo_di_testa'] + $skills['gioco_di_squadra'] + $skills['posizione'] + $skills['acrobazia']) / 7;

            $ruoli_specifici = [
                'fluidificante' => $fluidificante,
                'marcatore' => $marcatore,
                'interditore' => $interditore,
                'registaDifensivo' => $registaDifensivo,
                'regista' => $regista,
                'interno' => $interno,
                'fantasista' => $fantasista,
                'ala' => $ala,
                'secondaPunta' => $secondaPunta,
                'pivot' => $pivot,
            ];

            $DifesaZonaDifensori = ($skills['tattica'] + $skills['gioco_di_squadra']) / 2;           

            $DifesaUomoDifensori = ($skills['resistenza'] + $skills['contrasto']) / 2;

            $FuorigiocoDifensori = ($skills['velocita'] + $skills['resistenza'] + $skills['tattica'] + $skills['gioco_di_squadra'] + $skills['posizione']) / 5;

            $RaddoppioMarcaturaDifensori = ($skills['velocita'] + $skills['resistenza'] + $skills['contrasto'] + $skills['marcatura'] + $skills['posizione']) / 5;

            $CatenaccioDifensori = ($skills['contrasto'] + $skills['velocita']) / 2;

            $Pressing = ($skills['resistenza'] + $skills['contrasto'] + $skills['gioco_di_squadra']) / 3;

            $VieCentrali = ($skills['contrasto'] + $skills['tattica'] + $skills['tiro'] + $skills['passaggio'] + $skills['creativita'] + $skills['dribbling']) / 6;
            
            $VieCentraliAttacco = ($skills['tecnica'] + $skills['posizione']) / 2;

            $GiocoFasceCentro = ($skills['velocita'] + $skills['passaggio'] + $skills['tecnica'] + $skills['dribbling'] + $skills['resistenza'] + $skills['gioco_di_squadra']) / 6;

            $GiocoFasceAttacco = ($skills['colpo_di_testa'] + $skills['acrobazia']) / 2;

            $stili = [
                'difesa_zona' => $DifesaZonaDifensori, 
                'difesa_uomo' => $DifesaUomoDifensori, 
                'fuorigioco' => $FuorigiocoDifensori, 
                'raddoppio' => $RaddoppioMarcaturaDifensori, 
                'catenaccio' => $CatenaccioDifensori,
                'pressing' => $Pressing, 
                'vie_centrali_centrocampo' => $VieCentrali,
                'vie_centrali_attacco' => $VieCentraliAttacco, 
                'facsce_attacco' => $GiocoFasceAttacco, 
                'fasce_centrocampo' => $GiocoFasceCentro
            ];

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
