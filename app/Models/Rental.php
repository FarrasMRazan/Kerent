<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clothe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'settlement';
    const STATUS_EXPIRED = 'expire';
    const STATUS_CANCEL  = 'cancel';

    protected $fillable = [
        'order_id', 'user_id', 'clothe_id', 'start_date', 
        'end_date', 'duration', 'total_price', 'status_payment', 
        'status_barang', 'snap_token', 'size',
        'user_address', 'user_lat', 'user_lng', 
        'current_lat', 'current_lng',
        'penalty_fee'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'size' => 'array', 
        'penalty_fee' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clothe()
    {
        return $this->belongsTo(Clothe::class)->withDefault([
            'character_name' => 'Kostum Dihapus',
            'image' => 'default.jpg'
        ]);
    }

    public function getDurationAttribute($value)
    {
        return $value ?: 1;
    }

    public function getPenaltyFeeAttribute($value)
    {
        // Jika status sudah returned
        if ($this->status_barang === 'returned') {
            $deadline = Carbon::parse($this->end_date)->startOfDay();
            $now = now()->startOfDay();
            if ($now->gt($deadline)) {
                $daysLate = $now->diffInDays($deadline);
                return max($value, $daysLate * 50000); // 50rb per hari
            }
        }
        return $value;
    }

}