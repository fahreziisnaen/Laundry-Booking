<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_code',
        'address',
        'latitude',
        'longitude',
        'package_id',
        'estimated_weight',
        'pickup_time',
        'notes',
        'status',
        'total_amount'
    ];

    protected $casts = [
        'pickup_time' => 'datetime',
        'estimated_weight' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PICKUP_IN_PROGRESS = 'pickup_in_progress';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_PROCESSING = 'processing';
    const STATUS_READY_FOR_DELIVERY = 'ready_for_delivery';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function photos()
    {
        return $this->hasMany(BookingPhoto::class);
    }

    public static function generateBookingCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('booking_code', $code)->exists());
        
        return $code;
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_PICKUP_IN_PROGRESS => 'Pickup In Progress',
            self::STATUS_PICKED_UP => 'Picked Up',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_READY_FOR_DELIVERY => 'Ready for Delivery',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getNextPossibleStatuses()
    {
        return match($this->status) {
            self::STATUS_PENDING => [
                self::STATUS_CONFIRMED => 'Confirm',
                self::STATUS_CANCELLED => 'Cancel',
            ],
            self::STATUS_CONFIRMED => [
                self::STATUS_PICKUP_IN_PROGRESS => 'Start Pickup',
                self::STATUS_CANCELLED => 'Cancel',
            ],
            self::STATUS_PICKUP_IN_PROGRESS => [
                self::STATUS_PICKED_UP => 'Mark as Picked Up',
                self::STATUS_CONFIRMED => 'Back to Confirmed',
            ],
            self::STATUS_PICKED_UP => [
                self::STATUS_PROCESSING => 'Start Processing',
            ],
            self::STATUS_PROCESSING => [
                self::STATUS_READY_FOR_DELIVERY => 'Ready for Delivery',
            ],
            self::STATUS_READY_FOR_DELIVERY => [
                self::STATUS_COMPLETED => 'Mark as Completed',
            ],
            self::STATUS_CANCELLED => [],
            self::STATUS_COMPLETED => [],
            default => [],
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_PICKUP_IN_PROGRESS => 'bg-purple-100 text-purple-800',
            self::STATUS_PICKED_UP => 'bg-indigo-100 text-indigo-800',
            self::STATUS_PROCESSING => 'bg-orange-100 text-orange-800',
            self::STATUS_READY_FOR_DELIVERY => 'bg-cyan-100 text-cyan-800',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
