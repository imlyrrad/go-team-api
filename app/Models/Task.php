<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date_due',
        'is_completed',
        'user_id'
    ];

    public function scopeOwned($query)
    {
        $user_id = Auth()->user()->id;
        return $query->where('user_id', $user_id);
    }
}
