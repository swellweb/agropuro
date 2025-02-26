<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowcaseController extends Controller
{
    protected $limits = [
        'roots' => 5,
        'supply' => 50,
        'farm' => 100,
    ];

    public function index()
    {
        $user = Auth::user();
        if (!$user ) {
            return response()->json(['error' => 'Non autorizzato'], 401);
        }

        if ($user->hasRole('administrator')) {
            $products = Product::all();
            return response()->json($products);
        }

        // Se l'utente è un farmer, restituisci solo i suoi prodotti
        if ($user->hasRole('farmer')) {
            $products = $user->farmer->products;
            return response()->json($products);
        }

        return response()->json(['error' => 'Non autorizzato'], 403);
    }

    public function store(Request $request)
    {
        $farmer = auth()->user()->farmer;
        $count = $farmer->products->count();
        $limit = $this->limits[auth()->user()->subscription];

        if ($count >= $limit) {
            return response()->json(['error' => 'Limite raggiunto'], 403);
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'tipo' => 'required|string|in:Frutta,Verdura,Lattiero-Caseari,Cereali,Legumi,Prodotti Trasformati,Carni e Salumi,Pesce e Frutti di Mare,Miele e Derivati,Bevande',
            'prezzo' => 'nullable|numeric|min:0',
            'quantita_disponibile' => 'required|integer|min:0',
            'unita_misura' => 'required|string|in:kg,litri,pezzi',
            'immagine' => 'nullable|image|max:2048',
            'video' => auth()->user()->subscription !== 'base' ? 'nullable|file|mimes:mp4|max:10240' : 'forbidden',
            'galleria.*' => auth()->user()->subscription === 'gold' ? 'nullable|image|max:2048' : 'forbidden',
            'tag' => 'nullable|array',
            'stagionalita' => 'nullable|string',
            'certificazioni' => 'nullable|string',
        ]);

        if ($request->hasFile('immagine')) {
            $file = $request->file('immagine');
            $userId = Auth::id();
            $titoloProdotto = \Str::slug($data['nome']); // Converte il nome in slug (es. "Mela Golden" -> "mela-golden")
            $extension = $file->getClientOriginalExtension(); // Ottiene l'estensione (es. "jpg")
            $path = "dataimages/users/{$userId}/prodotti"; // Percorso cartella
            $filename = "{$titoloProdotto}.{$extension}"; // Nome file

            // Salva il file nella posizione specificata
            $data['immagine'] = $file->storeAs($path, $filename, 'public');
        } else {
            $data['immagine'] = "default/{$data['tipo']}.jpg";
        }


        $data['farmer_id'] = $farmer->id;
        if ($request->hasFile('immagine')) {
            $data['immagine'] = $request->file('immagine')->store('prodotti', 'public');
        } else {
            $data['immagine'] = "default/{$data['tipo']}.jpg"; // Immagine default per categoria
        }
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }
        if ($request->hasFile('galleria')) {
            $data['galleria'] = collect($request->file('galleria'))->map(fn($file) => $file->store('galleria', 'public'))->toArray();
        }

        $product = Product::create($data);
        return response()->json($product, 201);
    }
    // Altri metodi CRUD simili
}
