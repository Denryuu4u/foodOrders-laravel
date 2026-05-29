<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'quantity',
        'price',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: total cost
    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    // Status badge color helper
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'Pending'   => 'warning',
            'Preparing' => 'info',
            'Delivered' => 'success',
            'Cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}
