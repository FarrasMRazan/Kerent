<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothe extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_name',
        'series_name',
        'include_items',
        'image',
        'category_id',
        'price_per_day',
        'user_id',
    ];

    /**
     * Relasi ke tabel ukuran & stok
     */
    public function sizes()
    {
        return $this->hasMany(ClotheSize::class);
    }

    /**
     * Relasi ke kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Umum'
        ]);
    }

    /**
     * Relasi ke rental
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Total stok dari semua ukuran
     */
    public function getTotalStockAttribute()
    {
        return $this->sizes->sum('stock');
    }

    /**
     * Cek apakah ALL SIZE tersedia
     * ALL SIZE = S, M, L, XL semuanya ADA & stok > 0
     */
    public function isAllSize(): bool
    {
        $requiredSizes = ['S', 'M', 'L', 'XL'];

        return $this->sizes
            ->whereIn('size', $requiredSizes)
            ->count() === count($requiredSizes)
            && $this->sizes
                ->whereIn('size', $requiredSizes)
                ->every(fn ($s) => $s->stock > 0);
    }
}
