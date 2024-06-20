<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tour extends Model
{
    use HasFactory, Filterable, AsSource;

    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'from',
        'to',
        'max_people',
        'date',
        'price',
    ];

    protected $allowedSorts = [
        'name',
        'from',
        'to',
        'max_people',
        'date',
        'price',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
