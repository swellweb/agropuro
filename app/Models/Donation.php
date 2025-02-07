<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'donor_name',
        'donor_email',
    ];

    /**
     * Get the user that owns the donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
