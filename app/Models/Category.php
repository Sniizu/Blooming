<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeFilter($query)
    {
        if (request('search')) {
            return
            $query->where('name', 'like', '%' . request('search') . '%');
        }
    }
}
