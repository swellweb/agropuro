<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'farm_name',
        'lat',
        'lng',
        'product'
    ];

    /**
     * Get the user that owns the farmer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
