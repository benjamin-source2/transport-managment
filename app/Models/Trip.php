<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = ['bus_id', 'route_id', 'date', 'base_price'];

    protected $casts = ['date' => 'date', 'base_price' => 'decimal:2'];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function remainingSeats(): int
    {
        $booked = $this->bookings()->count();
        return $this->bus->capacity - $booked;
    }

    public function isFull(): bool
    {
        return $this->remainingSeats() <= 0;
    }

    public function totalRevenue(): float
    {
        return $this->bookings()->sum('price');
    }
}
