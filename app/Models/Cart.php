<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Pastikan start_date dan end_date ada di sini agar bisa disimpan ke database
    protected $fillable = [
        'user_id', 
        'clothe_id', 
        'size', 
        'start_date', 
        'end_date'
    ];

    /**
     * Relasi ke model Clothe (Baju)
     */
    public function clothe()
    {
        return $this->belongsTo(Clothe::class);
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}