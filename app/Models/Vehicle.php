<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicle';

    protected $fillable = [
        'user_id', 'plate_num', 'brand', 'model', 'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}