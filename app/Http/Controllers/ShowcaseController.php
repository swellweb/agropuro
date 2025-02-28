<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
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
        if (!$user) {
            return response()->json(['error' => 'Non autenticato'], 401);
        }

        if ($user->hasRole('administrator')) {
            // Carica tutti i prodotti con i tag per gli amministratori
            return response()->json(Product::with('tags')->get());
        }

        if ($user->isFarmer()) {
            // Carica i prodotti del farmer con i tag
            return response()->json($user->farmer->products()->with('tags')->get());
        }

        return response()->json(['error' => 'Non autorizzato'], 403);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isFarmer()) {
            return response()->json(['error' => 'Non hai una fattoria associata'], 403);
        }

        $farmer = $user->farmer;
        $count = $farmer->products->count();
        $limit = $this->limits[$user->subscription];

        if ($count >= $limit) {
            return response()->json(['error' => 'Limite prodotti raggiunto'], 403);
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'tipo' => 'required|in:Frutta,Verdura,Lattiero-Caseari,Cereali,Legumi,Prodotti Trasformati,Miele e Derivati,Bevande,Vino',
            'prezzo' => 'nullable|numeric|min:0',
            'quantita_disponibile' => 'required|integer|min:0',
            'unita_misura' => 'required|in:kg,litri,pezzi',
            'immagine' => 'nullable|image|max:2048',
            'video' => $user->subscription !== 'base' ? 'nullable|file|mimes:mp4|max:10240' : 'forbidden',
            'galleria.*' => $user->subscription === 'gold' ? 'nullable|image|max:2048' : 'forbidden',
            'tag' => 'nullable|string', // Cambiato da array a string
            'stagionalita' => 'nullable|string',
            'certificazioni' => 'nullable|string',
        ]);

        $data['farmer_id'] = $farmer->id;
        if ($request->hasFile('immagine')) {
            $file = $request->file('immagine');
            $userId = Auth::id();
            $titoloProdotto = \Str::slug($data['nome']);
            $extension = $file->getClientOriginalExtension();
            $path = "dataimages/users/{$userId}/prodotti";
            $data['immagine'] = $file->storeAs($path, "{$titoloProdotto}.{$extension}", 'public');
        } else {
            $tipoProdotto = \Str::slug($data['tipo']);
            $data['immagine'] = "default/{$tipoProdotto}.webp";
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }
        if ($request->hasFile('galleria')) {
            $data['galleria'] = collect($request->file('galleria'))->map(fn($file) => $file->store('galleria', 'public'))->toArray();
        }

        $product = Product::create($data);

        if (!empty($data['tag'])) {
            $tagsArray = json_decode($data['tag'], true); // Decodifica JSON in array
            if (is_array($tagsArray)) {
                $tagIds = collect($tagsArray)->map(function ($tagName) {
                    $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                    \Log::info('Tag elaborato:', ['name' => $tagName, 'id' => $tag->id]);
                    return $tag->id;
                })->unique()->take(5)->all();
                $product->tags()->sync($tagIds);
                \Log::info('Tag sincronizzati per product_id ' . $product->id, ['tag_ids' => $tagIds]);
            } else {
                \Log::warning('Tag non è un array valido:', ['tag' => $data['tag']]);
            }
        } else {
            \Log::info('Nessun tag fornito per product_id ' . $product->id);
        }

        return response()->json($product->load('tags'), 201);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isFarmer()) {
            return response()->json(['error' => 'Non hai una fattoria associata'], 403);
        }

        $product = Product::where('farmer_id', $user->farmer->id)->findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descrizione' => 'nullable|string',
            'tipo' => 'required|in:Frutta,Verdura,Lattiero-Caseari,Cereali,Legumi,Prodotti Trasformati,Miele e Derivati,Bevande,Vino',
            'prezzo' => 'nullable|numeric|min:0',
            'quantita_disponibile' => 'required|integer|min:0',
            'unita_misura' => 'required|in:kg,litri,pezzi',
            'immagine' => 'nullable|image|max:2048',
            'video' => $user->subscription !== 'base' ? 'nullable|file|mimes:mp4|max:10240' : 'forbidden',
            'galleria.*' => $user->subscription === 'gold' ? 'nullable|image|max:2048' : 'forbidden',
            'tag' => 'nullable|string',
            'stagionalita' => 'nullable|string',
            'certificazioni' => 'nullable|string',
        ]);

        if ($request->hasFile('immagine')) {
            $file = $request->file('immagine');
            $userId = Auth::id();
            $titoloProdotto = Str::slug($data['nome']);
            $extension = $file->getClientOriginalExtension();
            $path = "dataimages/users/{$userId}/prodotti";
            $data['immagine'] = $file->storeAs($path, "{$titoloProdotto}.{$extension}", 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }
        if ($request->hasFile('galleria')) {
            $data['galleria'] = collect($request->file('galleria'))->map(fn($file) => $file->store('galleria', 'public'))->toArray();
        }

        $product->update($data);

        if (!empty($data['tag'])) {
            $tagsArray = json_decode($data['tag'], true);
            if (is_array($tagsArray)) {
                $tagIds = collect($tagsArray)->map(function ($tagName) {
                    return Tag::firstOrCreate(['name' => trim($tagName)])->id;
                })->unique()->take(5)->all();
                $product->tags()->sync($tagIds);
            }
        } else {
            $product->tags()->sync([]); // Rimuove tutti i tag se non forniti
        }

        return response()->json($product->load('tags'), 200);
    }


    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isFarmer()) {
            return response()->json(['error' => 'Non hai una fattoria associata'], 403);
        }

        $product = Product::where('farmer_id', $user->farmer->id)->findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Prodotto rimosso con successo'], 200);
    }

    public function searchTags(Request $request)
    {
        $query = $request->input('query');
        $tags = Tag::where('name', 'like', "%{$query}%")
            ->withCount('products') // Conteggio prodotti che usano il tag
            ->limit(10)
            ->get()
            ->map(function ($tag) {
                return [
                    'name' => $tag->name,
                    'usage_count' => $tag->products_count,
                ];
            });

        return response()->json($tags);
    }
}
