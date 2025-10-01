<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'description',
        'date',
    ];

   
    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}