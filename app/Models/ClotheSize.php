<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClotheSize extends Model
{
    protected $fillable = ['clothe_id', 'size', 'stock'];

    public function clothe()
    {
        return $this->belongsTo(Clothe::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $allowedSizes = ['S', 'M', 'L', 'XL'];

            if (!in_array($model->size, $allowedSizes)) {
                throw new \Exception('Ukuran tidak valid');
            }
        });
    }
}
