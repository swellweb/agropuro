<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id', 'nome', 'descrizione', 'tipo', 'prezzo', 'quantita_disponibile',
        'unita_misura', 'immagine', 'video', 'galleria', 'tag', 'stagionalita', 'certificazioni',
    ];

    protected $casts = [
        'tag' => 'array',
        'galleria' => 'array',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
