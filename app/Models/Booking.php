<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Booking extends Model
{
    use HasFactory, Filterable, AsSource;

    protected $fillable = [
        'user_id',
        'tour_id',
        'card',
    ];

    protected $allowedSorts = [
        'user_id',
        'tour_id',
        'card',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
