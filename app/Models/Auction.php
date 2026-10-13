<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'starting_price',
        'current_price',
        'start_time',
        'end_time',
        'image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

public function updateStatus(): void
{
    $now = now();

    if ($now->lt($this->start_time)) {
        $this->update(['status' => 'pending']);
    } elseif ($now->gte($this->start_time) && $now->lt($this->end_time)) {
        $this->update(['status' => 'active']);
    } else {
        $this->update(['status' => 'closed']);
    }
}
}
